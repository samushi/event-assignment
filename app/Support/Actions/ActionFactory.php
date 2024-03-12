<?php

declare(strict_types=1);

namespace App\Support\Actions;

use Exception;

abstract class ActionFactory
{
    /**
     * Make instance
     */
    public static function make(): self
    {
        return app(static::class);
    }

    /**
     * Run Action
     *
     * @param  null  ...$args
     *
     * @throws Exception
     */
    public static function run(...$args): mixed
    {
        return static::make()->handle(...$args);
    }
}
