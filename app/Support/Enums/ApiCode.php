<?php

declare(strict_types=1);

namespace App\Support\Enums;

use Illuminate\Support\Facades\Lang;

enum ApiCode: int
{
    case SOMETHING_WENT_WRONG = 250;
    case INVALID_CREDENTIALS = 251;
    case INVALID_VALIDATION = 252;

    /**
     * Get Message By Status code
     */
    public function message(): string
    {
        return match ($this) {
            self::SOMETHING_WENT_WRONG => Lang::get('api.something_went_wrong'),
            self::INVALID_CREDENTIALS => Lang::get('api.invalid_credentials'),
            self::INVALID_VALIDATION => Lang::get('api.invalid_validation')
        };
    }
}
