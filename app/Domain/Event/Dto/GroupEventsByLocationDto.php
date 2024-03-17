<?php

namespace App\Domain\Event\Dto;

use App\Support\DataObjects;

class GroupEventsByLocationDto extends DataObjects
{
    public function __construct(
        public readonly string $start,
        public readonly string $end,
        public readonly ?int $page,
        public readonly ?int $perPage
    ) {
    }
}
