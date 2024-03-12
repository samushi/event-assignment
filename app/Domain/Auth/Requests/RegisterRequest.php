<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;

use App\Support\FormRequest;

final class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
