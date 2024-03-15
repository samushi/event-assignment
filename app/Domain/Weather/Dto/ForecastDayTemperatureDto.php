<?php

namespace App\Domain\Weather\Dto;

use App\Support\DataObjects;

class ForecastDayTemperatureDto extends DataObjects
{
    public function __construct(
        public readonly float $average,
        public readonly float $maximum,
        public readonly float $minimum
    ) {
    }
}
