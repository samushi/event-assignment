<?php

namespace App\Domain\Weather\Dto;

use App\Support\DataObjects;

class ForecastDaySpecificTimeForecastDto extends DataObjects
{
    public function __construct(
        public readonly string $time,
        public readonly float $temperature,
        public readonly float $feelsLike,
        public readonly string $condition,
        public readonly float $chanceOfRain,
        public readonly float $visibility
    ) {
    }
}
