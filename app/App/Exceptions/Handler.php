<?php

namespace App\Exceptions;

use App\Support\Enums\ApiCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use League\OAuth2\Server\Exception\OAuthServerException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $dontReport = [
        OAuthServerException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render exceptions
     *
     * @throws Throwable
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        if (($e instanceof HttpException || $e instanceof AuthenticationException || $e instanceof OAuthServerException) && $request->expectsJson()) {
            return $this->unAuthenticatedExceptions($e);
        }

        // If Unauthorized use to do any action
        if ($e instanceof AuthorizationException && $request->expectsJson()) {
            return $this->unAuthorize();
        }

        // When model not found
        if ($e instanceof ModelNotFoundException) {
            return $this->notFound();
        }

        // Force to application/json rendering API Calls
        if ($request->is('api/v1/*')) {
            $request->headers->set('Accept', 'application/json');
        }

        return parent::render($request, $e);
    }

    /**
     * @throws InvalidTypeException
     * @throws NotIntegerException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws ArrayWithMixedKeysException
     * @throws MissingConfigurationKeyException
     */
    private function unAuthorize(): Response
    {
        return ResponseBuilder::asError(ApiCode::SOMETHING_WENT_WRONG->value)
            ->withMessage(Lang::get('api.something_went_wrong'))
            ->withHttpCode(Response::HTTP_UNAUTHORIZED)
            ->build();
    }

    /**
     * Show Json response when not found
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    private function notFound(): Response
    {
        return ResponseBuilder::asError(ApiCode::SOMETHING_WENT_WRONG->value)
            ->withMessage(Lang::get('api.not_found'))
            ->withHttpCode(Response::HTTP_NOT_FOUND)
            ->build();
    }

    /**
     * Check if unauthenticated
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    private function unAuthenticatedExceptions(Throwable $e): Response
    {
        return ResponseBuilder::asError(ApiCode::INVALID_VALIDATION->value)
            ->withHttpCode(Response::HTTP_BAD_REQUEST)
            ->withMessage($e->getMessage())
            ->build();
    }
}
