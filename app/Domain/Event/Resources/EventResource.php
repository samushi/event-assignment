<?php

namespace App\Domain\Event\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $event_date
 * @property array $weather_prediction
 */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'weather_prediction' => $this->weather_prediction
        ];
    }
}
