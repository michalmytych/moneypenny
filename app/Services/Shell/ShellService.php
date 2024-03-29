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
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return json_encode(['error' => implode(PHP_EOL, $output)]);
        }

        return implode(PHP_EOL, $output);
    }

    public function runScript(string $scriptName, array $args = []): string
    {
        $scriptPath = $this->scriptPath . '/' . $scriptName;
        $command = "bash " . $scriptPath . ' ' . implode(' ', $args);
        return $this->executeCommand($command);
    }
}
