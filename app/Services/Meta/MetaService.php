<?php

namespace App\Services\Meta;

use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Services\Logging\LoggingAdapterInterface;
use App\Services\Shell\ShellService;
use App\Services\SSH\SshService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class MetaService
{
    public function __construct(
        private ShellService            $shellService,
        private CacheAdapterInterface   $cacheAdapter,
        private LoggingAdapterInterface $loggingAdapter,
        private SshService              $sshService,
    ) {}

    public function updateSystem(): array
    {
        $targetHost = gethostbyname(config('admin-ssh.host'));
        $currentHost = $this->getLocalIp();

        $commands = ['./deploy_moneypenny.sh'];
        $results = [];

        if ($targetHost === $currentHost) {
            foreach ($commands as $command) {
                $output = shell_exec($command . ' 2>&1');
                $results[] = [
                    'command' => $command,
                    'output' => explode("\n", trim($output)),
                ];
            }
        } else {
            $this->sshService->connect(
                config('admin-ssh.host'),
                (int) config('admin-ssh.port'),
                config('admin-ssh.username'),
                config('admin-ssh.password'),
            );
            $results = $this->sshService->executeCommands($commands);
        }

        $logPath = storage_path('logs/system_ssh.log');
        $last = end($results);
        $lastLine = '[ ' . now()->toDateTimeString() . ' ] ' . $last['command'] . ' → ' . implode(' | ', $last['output']) . PHP_EOL;
        file_put_contents($logPath, $lastLine, FILE_APPEND);
        $connectionLog = file_exists($logPath) ? file($logPath, FILE_IGNORE_NEW_LINES) : [];

        return [
            'results' => $results,
            'connection_log' => $connectionLog,
            '__meta' => [
                'target_host' => $targetHost,
                'current_host' => $currentHost
            ],
        ];
    }

    public function getAppMetaData(): array
    {
        $cacheKey = 'app_meta_data';

        if ($this->cacheAdapter->has($cacheKey)) {
            return $this->cacheAdapter->get($cacheKey);
        }

        $appMetaData = [
            'disk_free' => $this->getDiskFree(),
            'system_info' => $this->getSystemInfo(),
            'directories_sizes' => [
                base_path() => $this->getDirectorySize(base_path()),
                app_path() => $this->getDirectorySize(app_path()),
                public_path() => $this->getDirectorySize(public_path()),
                config_path() => $this->getDirectorySize(resource_path()),
                base_path('/vendor') => $this->getDirectorySize(base_path('/vendor')),
                base_path('/docs') => $this->getDirectorySize(base_path('/docs')),
                base_path('/scripts') => $this->getDirectorySize(base_path('/scripts')),
                database_path() => $this->getDirectorySize(database_path()),
                storage_path() => $this->getDirectorySize(storage_path()),
                resource_path() => $this->getDirectorySize(resource_path()),
                base_path('/node_modules') => $this->getDirectorySize(base_path('/node_modules'))
            ],
            'database' => [
                'tables_sizes' => $this->getTablesSizes()
            ]
        ];

        $this->cacheAdapter->put($cacheKey, $appMetaData, 30);

        return $appMetaData;
    }

    public function getTopProcesses(): array
    {
        return ['processes' => $this->getTopData()];
    }

    /** @noinspection SqlDialectInspection */
    public function getTablesSizes(): array
    {
        try {
            return DB::table('information_schema.TABLES')
                ->select(DB::raw("table_name as `table`, ROUND(((data_length + index_length) / 1024 / 1024), 2) `size_MB`"))
                ->where('table_schema', 'laravel')
                ->orderBy(DB::raw("(data_length + index_length)"), 'desc')
                ->get()
                ->toArray();
        } catch (\Throwable $throwable) {
            $this->loggingAdapter->debug($throwable->getMessage(), [
                'trace' => $throwable->getTraceAsString(),
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ]);
            return [];
        }
    }

    protected function getTopData(): array
    {
        $data = $this->shellService->runScript('server_meta/top.sh');

        return json_decode($data, true) ?? [];
    }

    protected function getDirectorySize(string $directory): array
    {
        $data = $this->shellService->runScript('server_meta/directory_size.sh', [$directory]);

        return json_decode($data, true);
    }

    protected function getDiskFree(): array
    {
        $data = $this->shellService->runScript('server_meta/disk_free.sh');

        return json_decode($data, true);
    }

    protected function getSystemInfo(): array
    {
        $data = $this->shellService->runScript('server_meta/system_info.sh');

        return json_decode($data, true);
    }

    public function getJobsList(): Collection
    {
        $jobs = DB::table('jobs')->select()->latest()->get();

        if ($jobs->count() === 0) {
            $jobs = collect([
                [
                    'id' => 10,
                    'name' => 'CategorizeTransaction',
                    'queued_at' => '02-12-1999 13:12'
                ],
            ]);
        }

        return $jobs;
    }

    public function getLocalIp(): ?string
    {
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if ($sock === false) return null;

        socket_connect($sock, '8.8.8.8', 53);
        socket_getsockname($sock, $localIp);
        socket_close($sock);

        return $localIp;
    }
}
