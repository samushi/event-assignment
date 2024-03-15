<?php

namespace App\Domain\Weather;

use App\Domain\Weather\API\WeatherApiService;
use App\Support\AbstractServiceProvider;

class WeatherServiceProvider extends AbstractServiceProvider
{
    public function setDomain(): string
    {
        return 'Weather';
    }

    public function boot(): void
    {
        // Important to call the parent boot method
        parent::boot();

        // Bind the WeatherService to the container
        $this->app->singleton(abstract: WeatherApiService::class, concrete: fn () => new WeatherApiService(
            baseUrl: config('weather.api.url'),
            apiToken: config('weather.api.token')
        ));
    }
}
