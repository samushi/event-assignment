<?php

declare(strict_types=1);

namespace App\Domain\Auth\Repositories;

use App\Models\User;
use App\Support\Repositories;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends Repositories
{
    /**
     * Create new user
     */
    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getModel()->whereEmail($email)->first();
    }

    /**
     * Get User
     */
    protected function getModel(): Model
    {
        return new User();
    }
}
