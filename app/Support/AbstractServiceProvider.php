<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * Set Domain name
     */
    abstract public function setDomain(): string;

    /**
     * Service Provider when boot
     */
    public function boot(): void
    {
        // Load all migration from current domain name
        if ($this->getDomain()) {
            $migrationPath = base_path("app/Domain/{$this->getDomain()}/Migrations");
            $this->loadMigrationsFrom($migrationPath);
        }
    }

    /**
     * Service Provider when register
     */
    public function register(): void
    {
    }

    /**
     * Get domain name
     */
    private function getDomain(): ?string
    {
        return $this->setDomain();
    }
}
