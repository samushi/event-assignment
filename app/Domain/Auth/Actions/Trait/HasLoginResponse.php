<?php

declare(strict_types=1);

namespace App\Domain\Auth\Actions\Trait;

use App\Domain\Auth\Models\User;
use App\Support\Helpers\PassportHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\PersonalAccessTokenResult;

trait HasLoginResponse
{
    /**
     * Response data
     */
    private function responseToLogin(Model|User $user): array
    {
        // Create token
        $createToken = $this->createToken($user);

        // Get User Data
        $userData = $user->toArray();

        // Merge user data with access token data
        return [
            'token_type' => 'Bearer',
            'access_token' => $createToken->accessToken,
            'email_verified_at' => $userData['email_verified_at'],
            'expires_in' => $createToken->token->expires_at->diffInSeconds(Carbon::now()),
            'expires_at' => $createToken->token->expires_at->diffForHumans(Carbon::now()),
        ];
    }

    /**
     * Create user token
     */
    private function createToken(Model|User $user): PersonalAccessTokenResult
    {
        return $user->createToken(PassportHelper::getSecretKey());
    }
}
