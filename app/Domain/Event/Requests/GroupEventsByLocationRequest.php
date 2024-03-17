<?php

namespace App\Domain\Event\Requests;

use App\Support\FormRequest;

class GroupEventsByLocationRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'start' => ['required', 'date', 'before:end'],
            'end' => ['required', 'date', 'after:start'],
            'page' => ['sometimes', 'integer'],
            'per_page' => ['sometimes', 'integer'],
        ];
    }
}
