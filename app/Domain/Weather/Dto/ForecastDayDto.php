<?php

namespace App\Domain\Weather\Dto;

use App\Support\DataObjects;

class ForecastDayDto extends DataObjects
{
    public function __construct(
        public readonly string $date,
        public readonly string $weatherDescription,
        public readonly ForecastDayTemperatureDto|array $temperature,
        public readonly ForecastDaySpecificTimeForecastDto|array $specificTimeForecast
    )
    {
    }
}
