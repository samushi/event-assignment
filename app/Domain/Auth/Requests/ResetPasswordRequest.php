<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;

use App\Support\FormRequest;

final class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'min:6', 'max:6'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }
}
