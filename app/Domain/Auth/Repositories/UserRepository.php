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
     * @param array $data
     * @return User|Model
     */
    public function create(array $data): User|Model
    {
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }

    /**
     * Find User By Email
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->getModel()->whereEmail($email)->first();
    }

    /**
     * Find all Users By Email
     * @param array $emails
     * @return Collection|null
     */
    public function findAllByEmail(array $emails): ?Collection
    {
        return $this->getModel()->whereIn('email', $emails)->get();
    }

    /**
     * Get Model
     * @return Model
     */
    protected function getModel(): Model
    {
        return new User();
    }
}
