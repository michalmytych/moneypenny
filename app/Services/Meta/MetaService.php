<?php

namespace App\Services\Meta;

use App\Services\Shell\ShellService;

class MetaService
{
    public function __construct(private readonly ShellService $shellService)
    {
    }

    public function getAppMetaData(): array
    {
        $directorySize = $this->shellService->runScript('server_meta/directory_size.sh', [base_path()]);
        $diskFree = $this->shellService->runScript('server_meta/disk_free.sh');
        $systemInfo = $this->shellService->runScript('server_meta/system_info.sh');

        return [
            'directory_size' => json_decode($directorySize, true),
            'directory' => base_path(),
            'disk_free' => json_decode($diskFree, true),
            'system_info' => json_decode($systemInfo, true)
        ];
    }
}
