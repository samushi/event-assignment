<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;

use App\Support\FormRequest;

final class VerifyPasswordTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string', 'min:6', 'max:6']
        ];
    }
}
