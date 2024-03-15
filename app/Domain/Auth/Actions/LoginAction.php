<?php

namespace App\Domain\Auth\Actions;

use App\Domain\Auth\Actions\Trait\HasLoginResponse;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\UserRepository;
use App\Support\Actions\ActionFactory;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

final class LoginAction extends ActionFactory
{
    use HasLoginResponse;

    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    /**
     * Authenticate user
     */
    protected function handle(array $args): array|Exception
    {
        return DB::transaction(fn () => $this->responseToLogin($this->login($args['email'], $args['password'])));
    }

    /**
     * Login to the api
     */
    private function login(string $email, string $password): User|ValidationException
    {
        return DB::transaction(function () use ($email, $password) {
            $user = $this->repository->findByEmail($email);

            return ! $user || ! Hash::check($password, $user->password) ? $this->invalidCredentials() : $user;
        });
    }

    /**
     * Is not authenticated
     */
    private function invalidCredentials(): ValidationException
    {
        return throw ValidationException::withMessages([
            'email' => [Lang::get('api.invalid_credentials')],
        ]);
    }
}
