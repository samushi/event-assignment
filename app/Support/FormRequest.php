<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Enums\ApiCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as OFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

abstract class FormRequest extends OFormRequest
{
    abstract public function rules(): array;

    public function expectsJson(): bool
    {
        return true;
    }

    public function wantsJson(): bool
    {
        return true;
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Custom validation error
     *
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */
    protected function failedValidation(Validator $validator): void
    {
        $validators = (new ValidationException($validator));
        $message = $validators->getMessage();
        $errors = $validators->errors();

        throw new HttpResponseException(
            ResponseBuilder::asError(ApiCode::INVALID_VALIDATION->value)
                ->withHttpCode(Response::HTTP_UNAUTHORIZED)
                ->withMessage($message)
                ->withData($errors)
                ->build()
        );
    }
}
