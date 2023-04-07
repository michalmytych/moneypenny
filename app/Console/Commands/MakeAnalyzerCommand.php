<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputArgument;

class MakeAnalyzerCommand extends Command
{
    protected $signature = 'make:analyzer {name}';

    protected $description = 'Create a new analyzer class';

    public function handle()
    {
        $name = $this->argument('name');
        $className = Str::studly($name);

        $namespace = 'App\Services\Analysis\Analyzers';
        $path = app_path("Services/Analysis/Analyzers/{$className}.php");

        if (File::exists($path)) {
            $this->error("{$className} already exists.");
            return;
        }

        $stub = File::get(base_path('stubs/analyzer.stub'));
        $stub = str_replace('{{class}}', $className, $stub);
        $stub = str_replace('{{namespace}}', $namespace, $stub);

        File::put($path, $stub);

        $this->info("{$className} generated successfully.");
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the analyzer.'],
        ];
    }
}
