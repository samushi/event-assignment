<?php

namespace App\Domain\Event\Requests;

use App\Support\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'event_date' => [
                'sometimes',
                'date_format:Y-m-d H:i',
                'after_or_equal:'.now()->format('Y-m-d H:i'),
            ],
            'location' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'invitees' => ['sometimes', 'array'],
            'invitees.*' => ['required', 'exists:users,email'],
        ];
    }
}
