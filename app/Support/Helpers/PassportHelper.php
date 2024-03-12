<?php

declare(strict_types=1);

namespace App\Support\Helpers;

final class PassportHelper
{
    public static function getSecretKey()
    {
        return config('services.passport.token');
    }
}
