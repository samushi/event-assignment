<?php

namespace App\Domain\Event\Requests;

use App\Support\FormRequest;

class GetEventsByDateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'start' => ['required', 'date', 'before:end'],
            'end' => ['required', 'date', 'after:start'],
            'per_page' => ['sometimes', 'integer']
        ];
    }
}
