<?php

namespace App\Domain\Event\Dto;

use App\Support\DataObjects;

class EventDto extends DataObjects
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $creator,
        public readonly string $eventDate,
        public readonly string $location,
        public readonly string $description,
        public readonly array $weatherPrediction
    ) {
    }
}
