<?php

namespace App\Domain\Event\Resources;

use App\Domain\Event\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventsByIntervalDateResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'events' => $this->collection->map(fn (Event $event) => EventResource::make($event)->resolve())->toArray(),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];
    }
}
