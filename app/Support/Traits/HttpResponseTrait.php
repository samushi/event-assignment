<?php

declare(strict_types=1);

namespace App\Support\Traits;

use App\Support\Enums\ApiCode;
use Closure;
use Exception;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait HttpResponseTrait
{
    /**
     * Success Response
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function success(array $data, ?string $message = null): HttpResponse
    {
        return ResponseBuilder::asSuccess()
            ->withData($data)
            ->withMessage($message)
            ->build();
    }

    /**
     * Response without data
     *
     * @throws Exception
     */
    final protected function noContentClosure(Closure $closure): HttpResponse
    {
        try {
            $closure();

            return ResponseBuilder::asSuccess()->build();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Success response with message
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function successWithMessage(string $message): HttpResponse
    {
        return ResponseBuilder::asSuccess()->withMessage($message)->build();
    }

    /**
     * Error with message
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function errorWithMessage(string $message, int $apiCode = ApiCode::SOMETHING_WENT_WRONG->value): HttpResponse
    {
        return ResponseBuilder::asError($apiCode)->withMessage($message)->build();
    }

    /**
     * Bad request error
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function badRequest(int $apiCode): HttpResponse
    {
        return $this->error($apiCode, 400);
    }

    /**
     * Something is wrong
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function somethingWrong(int $apiCode): HttpResponse
    {
        $apiCode = $apiCode === 0 ? ApiCode::SOMETHING_WENT_WRONG->value : $apiCode;

        return $this->error($apiCode, HttpResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Unauthorized error
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function unAuthorized(?string $message): HttpResponse
    {
        return ResponseBuilder::asError(ApiCode::INVALID_CREDENTIALS->value)
            ->withHttpCode(HttpResponse::HTTP_UNAUTHORIZED)
            ->withMessage($message)
            ->build();
    }

    /**
     * Error response
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    final protected function error(int $apiCode, int $httpCode): HttpResponse
    {
        return ResponseBuilder::asError($apiCode)->withHttpCode($httpCode)->build();
    }
}
