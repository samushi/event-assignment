<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;

if (! function_exists('domainMigrationPathCreate')) {
    function domainMigrationPathCreate(string $domain): ?string
    {
        // Filesystem
        $filesystem = app(Filesystem::class);
        $path = base_path("app/Domain/{$domain}");

        if ($filesystem->isDirectory($path)) {
            // Domain Path
            $migrationPath = "app/Domain/{$domain}/Migrations";
            $appPath = base_path("app/Domain/{$domain}/Migrations");

            // Ensure the directory exists
            if (! $filesystem->isDirectory($appPath)) {
                $filesystem->makeDirectory($appPath, 0755, true);
            }

            return $migrationPath;
        }

        return null;
    }
}
