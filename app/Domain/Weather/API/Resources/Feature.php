<?php

namespace App\Domain\Weather\API\Resources;

use App\Domain\Weather\API\Resource;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;

final class Feature extends Resource
{
    protected ?string $prefix = 'future.json';

    /**
     * Get weather history for a city
     */
    public function get(string $city, Carbon $date): Response
    {
        return $this->service->get(
            url: $this->endpoint(),
            data: [
                'q' => $city,
                'dt' => $date->format('Y-m-d'),
                'hour' => $date->hour,
            ]
        );
    }
}
