<?php

declare(strict_types=1);

namespace App\Domain\Weather\API;

abstract class Resource
{
    protected ?string $prefix = null;

    public function __construct(public readonly WeatherApiService $service)
    {
    }

    /**
     * Make endpoint with prefix
     */
    protected function endpoint(?string $path = null): string
    {
        return $path ? "$this->prefix/$path" : "$this->prefix";
    }
}
