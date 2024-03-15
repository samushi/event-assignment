<?php

declare(strict_types=1);

namespace App\Domain\Auth\Controllers;

use App\Domain\Auth\Actions\LoginAction;
use App\Domain\Auth\Actions\LogoutAction;
use App\Domain\Auth\Actions\RegisterAction;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use App\Support\ApiControllers;
use Exception;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticationController extends ApiControllers
{
    /**
     * Login user
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function login(LoginRequest $request): Response
    {
        return rescue(
            fn () => $this->success(LoginAction::run($request->validated())),
            $this->throwValidationException()
        );
    }

    /**
     * Register User
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function register(RegisterRequest $request): ?Response
    {
        return rescue(
            function () use ($request) {
                $user = RegisterAction::run($request->validated());

                return $this->successWithMessage(
                    __('You have successfully registered, :first_name :last_name.', [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                    ]));
            },
            $this->throwValidationException()
        );
    }

    /**
     * Logout user
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function logout(Request $request): Response
    {
        return rescue(
            fn () => $this->successWithMessage(LogoutAction::run($request->user())),
            $this->throwValidationException()
        );
    }
}
