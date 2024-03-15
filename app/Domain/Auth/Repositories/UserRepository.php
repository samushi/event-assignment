<?php

declare(strict_types=1);

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Models\User;
use App\Support\Repositories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class UserRepository extends Repositories
{
    /**
     * Create User
     */
    public function create(array $data): User|Model
    {
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }

    /**
     * Find User By Email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->getModel()->whereEmail($email)->first();
    }

    /**
     * Find all Users By Email
     */
    public function findAllByEmail(array $emails): ?Collection
    {
        return $this->query()->whereIn('email', $emails)->get();
    }

    /**
     * Find all by id's
     */
    public function findAllById(array $ids): ?Collection
    {
        return $this->query()->whereIn('id', $ids)->get();
    }

    /**
     * Get Model
     */
    protected function getModel(): Model
    {
        return new User();
    }
}
