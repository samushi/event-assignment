<?php

declare(strict_types=1);

namespace App\Support\Commands;

use function App\Support\domainMigrationPathCreate;

use Illuminate\Console\Command;

final class CreateMigrationForDomain extends Command
{
    protected $description = 'All about domain migrations';
    protected $signature = 'assignment:domain:migrate {table : Migration commands} {domain : The domain name}';

    public function handle(): void
    {
        // Domain Name
        $domain = $this->argument('domain');
        $table = $this->argument('table');

        // Create Migration
        $this->callMigration($domain, $table);
    }

    /**
     * Call Migration Command
     * @param string $domain
     * @param string $table
     * @return void
     */
    private function callMigration(string $domain, string $table): void
    {
        $path = domainMigrationPathCreate($domain);
        if($path) {
            $this->call("make:migration", [
                "name" => $table,
                "--path" => $path
            ]);
            $this->info(__("Migration has been created successfully"));
        } else {
            $this->warn(__("Domain path not exists!!"));
        }
    }
}
