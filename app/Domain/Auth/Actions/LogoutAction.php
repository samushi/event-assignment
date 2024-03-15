<?php

declare(strict_types=1);

namespace App\Domain\Auth\Actions;

use App\Domain\Auth\Models\User;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

final class LogoutAction extends ActionFactory
{
    protected function handle(User $args): string
    {
        return DB::transaction(function () use ($args): string {
            $args->token()->revoke();

            return Lang::get('api.logout');
        });
    }
}
