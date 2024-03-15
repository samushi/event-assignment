<?php

declare(strict_types=1);

namespace App\Domain\Auth;

use App\Support\AbstractServiceProvider;
use App\Support\Enums\PassportExpires;
use Laravel\Passport\Passport;

final class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * Set domain name
     */
    public function setDomain(): string
    {
        return 'Auth';
    }

    public function boot(): void
    {
        // Parent boot
        parent::boot();

        // Configure passport expires
        Passport::tokensExpireIn(now()->addDays(PassportExpires::EXPIRE_IN_DAYS->value));
        Passport::refreshTokensExpireIn(now()->addDays(PassportExpires::REFRESH_TOKEN_IN_DAYS->value));
        Passport::personalAccessTokensExpireIn(now()->addDays(PassportExpires::PERSONAL_TOKEN_IN_DAYS->value));
    }

    public function register(): void
    {
    }
}
