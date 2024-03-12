<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;

use App\Support\FormRequest;

final class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
