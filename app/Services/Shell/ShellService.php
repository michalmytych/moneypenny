<?php

namespace App\Services\Shell;

class ShellService
{
    protected string $scriptPath;

    public function __construct()
    {
        $this->scriptPath = base_path('scripts');
    }

    public function executeCommand(string $command): string
    {
        return shell_exec($command);
    }

    public function runScript(string $scriptName, array $args = []): string
    {
        $scriptPath = $this->scriptPath . '/' . $scriptName;
        $command = "bash " . $scriptPath . ' ' . implode(' ', $args);
        return $this->executeCommand($command);
    }
}
