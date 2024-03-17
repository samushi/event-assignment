<?php

namespace App\Domain\Event\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupedEventsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // Ensure handling of pagination correctly
        $groupedAndSorted = $this->groupAndSortEvents($this->collection);
        return [
            'data' => $groupedAndSorted,
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

    /**
     * Group and sort events by location.
     *
     * @param Collection $events
     * @return array
     */
    protected function groupAndSortEvents(Collection $events): array
    {
        return $events
            ->groupBy('location')
            ->map(fn ($events, $location) => $this->formatEventsByLocation($events, $location))
            ->sortByDesc(fn ($group) => optional($group['events'][0])['event_date'] ?? null)
            ->values()
            ->all();
    }

    /**
     * Format the events for a specific location.
     *
     * @param Collection $events
     * @param string $location
     * @return array
     */
    protected function formatEventsByLocation(Collection $events, string $location): array
    {
        $sortedEvents = $events->sortByDesc('event_date');
        return [
            'location' => $location,
            'events' => EventResource::collection($sortedEvents)->resolve(),
        ];
    }
}
