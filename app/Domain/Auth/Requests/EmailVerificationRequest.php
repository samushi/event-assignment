<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;


use App\Support\FormRequest;

final class EmailVerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string','min_digits:6', 'max_digits:6']
        ];
    }

}
