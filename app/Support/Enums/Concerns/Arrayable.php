<?php

declare(strict_types=1);

namespace App\Support\Enums\Concerns;

trait Arrayable
{
    /**
     * Convert to array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
