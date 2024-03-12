<?php

declare(strict_types=1);

namespace App\Domain\Auth\Controllers;

use App\Domain\Auth\Actions\ResendVerifyEmail;
use App\Domain\Auth\Actions\VerifyEmail;
use App\Domain\Auth\Requests\EmailVerificationRequest;
use App\Support\Controllers\ApiControllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

final class VerificationController extends ApiControllers
{
    /**
     * Verify email
     * @param EmailVerificationRequest $request
     * @return HttpResponse
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function verify(EmailVerificationRequest $request): HttpResponse
    {
        return rescue(
            fn () => $this->successWithMessage(VerifyEmail::run($request->validated('token'), $request->user())),
            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
                $this->unAuthorized($throwable->getMessage()) :
                $this->errorWithMessage($throwable->getMessage())
        );
    }

    /**
     * Send verification email to the user when register
     *
     * @throws Exception
     */
    public function resend(Request $request): HttpResponse
    {
        return rescue(
            fn () => $this->successWithMessage(ResendVerifyEmail::run($request->user())),
            fn (Throwable $throwable) => $throwable instanceof ValidationException ?
                $this->unAuthorized($throwable->getMessage()) :
                $this->errorWithMessage($throwable->getMessage())
        );
    }
}
