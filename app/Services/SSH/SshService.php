<?php

namespace App\Services\SSH;

use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;
use Exception;

class SshService
{
    protected SSH2 $ssh;

    protected bool $connected = false;

    public function connect(string $host, int $port, string $username, string $password): void
    {
        $this->ssh = new SSH2($host, $port);
        $this->connected = $this->ssh->login($username, $password);

        if (!$this->connected) {
            throw new Exception("SSH connection failed.");
        }
    }

    /**
     * Execute multiple SSH commands and return their outputs.
     *
     * @param array $commands
     * @return array Each element contains ['stdout' => ..., 'stderr' => ...]
     */
    public function executeCommands(array $commands): array
    {
        if (!$this->connected) {
            throw new \Exception("Not connected to SSH.");
        }

        $results = [];

        foreach ($commands as $command) {
            $output = $this->ssh->exec("{$command} 2>&1");

            $results[] = [
                'command' => $command,
                'output' => explode("\n", trim($output)),
            ];
        }

        return $results;
    }
}
