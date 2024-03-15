<?php

declare(strict_types=1);

namespace App\Domain\Weather\API;

use App\Domain\Weather\API\Concerns\BuildBaseRequest;
use App\Domain\Weather\API\Concerns\CanGetRequest;
use App\Domain\Weather\API\Resources\Feature;

final class WeatherApiService
{
    use BuildBaseRequest, CanGetRequest;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiToken
    ) {
    }

    public function history(): Feature
    {
        return new Feature(service: $this);
    }
}
