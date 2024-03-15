<?php

namespace App\Domain\Event\Requests;

use App\Support\FormRequest;

class EventCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'event_date' => [
                'required',
                'date_format:Y-m-d H:i',
                'after_or_equal:'.now()->format('Y-m-d H:i'),
            ],
            'location' => ['required', 'string'],
            'description' => ['required', 'string'],
            'invitees' => ['required', 'array'],
            'invitees.*' => ['required', 'exists:users,email'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'invitees.*.exists' => 'The invitee does not exist',
        ];
    }
}
