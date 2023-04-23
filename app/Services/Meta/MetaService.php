<?php

namespace App\Services\Meta;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\Shell\ShellService;

class MetaService
{
    public function __construct(private readonly ShellService $shellService)
    {
    }

    public function getAppMetaData(): array
    {
        return [
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
            ]
        ];
    }

    public function getTopProcesses(): array
    {
        return ['processes' => $this->getTopData()];
    }

    /** @noinspection SqlDialectInspection */
    public function getTablesSizes(): Collection
    {
        return DB::table('information_schema.TABLES')
            ->select(DB::raw("table_name as `table`, ROUND(((data_length + index_length) / 1024 / 1024), 2) `size_MB`"))
            ->where('table_schema', 'laravel')
            ->orderBy(DB::raw("(data_length + index_length)"), 'desc')
            ->get();
    }

    protected function getTopData(): array
    {
        $data = $this->shellService->runScript('server_meta/top.sh');
        return json_decode($data, true);
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
}
