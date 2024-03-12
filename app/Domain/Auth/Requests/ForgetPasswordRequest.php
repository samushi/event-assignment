<?php

declare(strict_types=1);

namespace App\Domain\Auth\Requests;
use App\Support\FormRequest;

final class ForgetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
