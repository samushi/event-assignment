<?php

declare(strict_types=1);

namespace App\Domain\Auth\Controllers;


use App\Domain\Auth\Actions\LoginAction;
use App\Domain\Auth\Requests\ForgetPasswordRequest;
use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Requests\RegisterRequest;
use App\Domain\Auth\Requests\ResetPasswordRequest;
use App\Domain\Auth\Requests\VerifyPasswordTokenRequest;
use App\Support\ApiControllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
                $this->unAuthorized($throwable->getMessage()) :
                $this->errorWithMessage($throwable->getMessage())
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
//    public function register(RegisterRequest $request): ?Response
//    {
//        return rescue(
//            fn () => $this->successWithMessage(
//                __('Verifying your account by email (:email), one step closer to using our services.', ['email' => optional(RegisterUser::run($request->validated()))->email])
//            ),
//            fn (Throwable $throwable) => $this->somethingWrong($throwable->getCode())
//        );
//    }

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
//    public function logout(Request $request): Response
//    {
//        return rescue(
//            fn () => $this->successWithMessage(LogoutUser::run($request->user())),
//            fn (Throwable $throwable) => $this->somethingWrong($throwable->getCode())
//        );
//    }

    /**
     * Forget password
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
//    public function forget(ForgetPasswordRequest $request): Response
//    {
//        return rescue(
//            fn () => $this->successWithMessage(ForgetPassword::run($request->validated('email'))),
//            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
//                $this->unAuthorized($throwable->getMessage()) :
//                $this->errorWithMessage($throwable->getMessage())
//        );
//    }

    /**
     * Password reset
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
//    public function reset(ResetPasswordRequest $request): Response
//    {
//        return rescue(
//            fn () => $this->successWithMessage(ResetPassword::run($request->only('email', 'password', 'password_confirmation', 'token'))),
//            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
//                $this->unAuthorized($throwable->getMessage()) :
//                $this->errorWithMessage($throwable->getMessage())
//        );
//    }

    /**
     * Verify password token
     * @param VerifyPasswordTokenRequest $request
     * @return Response
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
//    public function verify(VerifyPasswordTokenRequest $request): Response
//    {
//        return rescue(
//            fn () => $this->success([
//                'is_valid_token' => VerifyPasswordToken::run($request->validated('email'), $request->validated('token')),
//                'email' => $request->validated('email')
//            ]),
//            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
//                $this->unAuthorized($throwable->getMessage()) :
//                $this->errorWithMessage($throwable->getMessage())
//        );
//    }
}
