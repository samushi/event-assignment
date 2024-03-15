<?php

declare(strict_types=1);

namespace App\Support\Commands;

use Illuminate\Console\Command;

final class Setup extends Command
{
    protected $signature = 'assignment:setup {--force : Skip confirmation}';

    protected $description = 'Reset Or Setup App';

    public function handle(): void
    {
        if ($this->option('force') || $this->confirm('Are you sure you wanna setup events mvp?')) {
            // Refresh database
            $this->info('Refreshing database...');
            $this->call('migrate:refresh', ['--seed' => true]);

            // Passport Setup
            $this->info('Passport setup');

            $this->option('force') ?
                $this->call('passport:install', ['--force' => true]) :
                $this->call('passport:install', ['--uuids' => true]);

            $this->info('Successfully has been setup');
        } else {
            $this->warn('Setup has been canceled');
        }
    }
}
