<?php

namespace App\Console\Commands\Setup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SetupApp extends Command
{
    protected $signature = 'moneypenny:setup-app';

    protected $description = 'Perform basic local application setup.';

    public function handle(): int
    {
        $this->info('Starting Moneypenny application setup.');

        $this->assureApplicationEnvironmentSetup();
        $this->generateAppKey();
        $this->clearConfigCache();
        $this->migrateDatabase();
        $this->seedDatabase();
        $this->performPostSetupCommands();

        $this->info('Setup finished.');

        return 0;
    }

    private function assureApplicationEnvironmentSetup(): void
    {
        $dotEnvFilePath = base_path('/.env');

        if (file_exists($dotEnvFilePath)) {
            $this->warn('Looks like .env file already exists. Quitting setup...');

            exit(1);
        }

        $templateEnvFilePath = base_path('/setup/env-template');

        if (!file_exists($templateEnvFilePath)) {
            $this->warn(
                'Looks like .env template file not exists. It should be present at path: [' .
                $templateEnvFilePath . ']. Quitting setup...'
            );

            exit(-1);
        }

        $templateEnvFileContents = file_get_contents($templateEnvFilePath);

        if (empty($templateEnvFileContents)) {
            $this->warn('Looks like .env template file is empty! Quitting setup...');

            exit(-2);
        }

        $this->info('Now, please setup your database connection.');

        $databaseConnection = $this->ask('Database connection name', 'mysql');
        $databaseHost = $this->ask('Database host', '127.0.0.1');
        $databasePort = $this->ask('Database port', '3306');
        $databaseName = $this->ask('Database name', 'laravel');
        $databaseUser = $this->ask('Database user', 'laravel');
        $databasePassword = $this->ask('Database password', '');

        $templateEnvFileContentsStringable = Str::of($templateEnvFileContents)
            ->replace('###DB_CONNECTION###', $databaseConnection)
            ->replace('###DB_HOST###', $databaseHost)
            ->replace('###DB_PORT###', $databasePort)
            ->replace('###DB_DATABASE###', $databaseName)
            ->replace('###DB_USERNAME###', $databaseUser)
            ->replace('###DB_PASSWORD###', $databasePassword);

        $this->info(
            'Ok. Now, if you want, you can setup other app services. ' .
            'Most of them are optional for now, but they may be required in production.'
        );

        $this->line(
            'Pusher is used for real-time user interface updates. ' . PHP_EOL .
            'Without it, some things like notifications delivering will not work properly. ' . PHP_EOL .
            'Of course you can setup it later in .env file.'
        );

        $pusherAppKey = $this->ask('Pusher app key (optional)', '');
        $pusherAppSecret = $this->ask('Pusher app secret (optional)', '');

        $this->line(
            'Nordigen API is an external service which is used to connect ' . PHP_EOL .
            'with financial institutions to fetch your financial data. ' . PHP_EOL .
            'Without it, app will not be fully working. ' . PHP_EOL .
            'Of course you can setup it later in .env file.'
        );

        $nordigenApiSecretId = $this->ask('Nordigen API secret ID (optional)', '');
        $nordigenApiSecretKey = $this->ask('Nordigen API secret KEY (optional)', '');

        $this->line(
            'ExchangeRates API is an external service which is used to fetch ' . PHP_EOL .
            'historical currencies exchange rates. Without it, app will not be fully working. ' . PHP_EOL .
            'Of course you can setup it later in .env file.'
        );

        $exchangeRatesApiKey = $this->ask('ExchangeRates API KEY (optional)', '');

        $templateEnvFileContents = $templateEnvFileContentsStringable
            ->replace('###PUSHER_APP_KEY###', $pusherAppKey)
            ->replace('###PUSHER_APP_SECRET###', $pusherAppSecret)
            ->replace('###NORDIGEN_API_SECRET_ID###', $nordigenApiSecretId)
            ->replace('###NORDIGEN_API_SECRET_KEY###', $nordigenApiSecretKey)
            ->replace('###EXCHANGE_RATES_API_KEY###', $exchangeRatesApiKey)
            ->toString();

        $this->info("Ok, that's all for now! Let me generate new .env file...");

        $filePutResult = file_put_contents($dotEnvFilePath, $templateEnvFileContents);

        if ($filePutResult) {
            $this->info("Generated new .env file!");

            return;
        }

        $this->error("Error while generating new env file!");

        exit(-3);
    }

    private function generateAppKey(): void
    {
        $this->info('Generating app key...');

        $exitCode = Artisan::call('key:generate');

        if ($exitCode === 0) {
            $this->info('App key generated.');

            return;
        }

        $this->error('Error while generating app key. ');
        $this->line('Try to run: php artisan key:generate');

        exit(-4);
    }

    private function migrateDatabase(): void
    {
        $this->info('Migrating database...');

        $exitCode = Artisan::call('migrate', [
            '--force' => true,
        ]);

        if ($exitCode === 0) {
            $this->info('Database migrated.');

            return;
        }

        $this->error('Error while migrating database!');
        $this->line('Try to run: php artisan key:generate');

        exit(-5);
    }

    private function seedDatabase(): void
    {
        $this->info('Seeding database...');

        $exitCode = Artisan::call('db:seed', [
            '--force' => true,
        ]);

        if ($exitCode === 0) {
            $this->info('Database seeded.');

            return;
        }

        $this->error('Error while seeding database. ');
        $this->line('Try to run: php artisan db:seed');

        exit(-6);
    }

    private function performPostSetupCommands(): void
    {
        $this->info('Performing post setup commands...');

        $exitCode = array_sum([
            Artisan::call('moneypenny:create-users-personal-accounts'),
            Artisan::call('moneypenny:create-users-settings')
        ]);

        if ($exitCode === 0) {
            $this->info('Post setup task performed.');

            return;
        }

        $this->error('Error while performing post setup tasks. ');
        $this->line('Try to run: php artisan moneypenny:create-users-personal-accounts');
        $this->line('Try to run: php artisan moneypenny:create-users-settings');

        exit(-7);
    }

    private function clearConfigCache(): void
    {
        $this->info('Clearing config cache...');

        $exitCode = Artisan::call('config:cache');

        if ($exitCode === 0) {
            $this->info('Config cache cleared.');

            return;
        }

        $this->error('Error while clearing config cache. ');
        $this->line('Try to run: php artisan config:cache');

        exit(-8);
    }
}
