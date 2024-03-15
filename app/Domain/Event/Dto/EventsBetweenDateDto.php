<?php

namespace App\Domain\Event\Dto;

use App\Support\DataObjects;

class EventsBetweenDateDto extends DataObjects
{
    public function __construct(
        public readonly string $start,
        public readonly string $end,
        public readonly ?int $perPage
    ) {
    }
}
