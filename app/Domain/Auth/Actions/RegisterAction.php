<?php

declare(strict_types=1);

namespace App\Domain\Auth\Actions;


use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Auth\Models\User;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;

final class RegisterAction extends ActionFactory
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    /**
     * Handle Action
     * @param array $args
     * @return User|null
     */
    protected function handle(array $args): ?User
    {
        return DB::transaction(fn () => $this->repository->create(data: $args));
    }
}
