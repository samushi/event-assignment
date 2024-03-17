<?php

namespace App\Domain\Event\Repositories;

use App\Domain\Auth\Models\User;
use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Event\Dto\UpdateRequestEventDto;
use App\Domain\Event\Models\Event;
use App\Support\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends Repositories
{
    protected function getModel(): Model
    {
        return new Event();
    }

    /**
     * Get all events by location and group by location and order by event date
     * @param string $start
     * @param string $end
     * @param string $orderBy
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function groupByLocation(string $start, string $end, string $orderBy = 'event_date', int $perPage = 10): LengthAwarePaginator
    {
        return $this->betweenDate($start, $end)
            ->orderBy($orderBy)
            ->paginate($perPage);
    }

    /**
     * Save event for creator
     */
    public function saveEvent(User $creator, CreateEventDto $dto, array $prediction): Event|Model
    {
        $event = $this->getModel()->fill([
            ...$dto->toArray(),
            'weather_prediction' => $prediction,
        ]);

        return $creator->event()->save($event);
    }

    /**
     * Update Event
     */
    public function updateEvent(Event $event, UpdateRequestEventDto $dto, array $prediction): Event|Model
    {
        $attributes = [
            'title' => $dto->title ?? $event->title,
            'event_date' => $dto->eventDate ?? $event->event_date,
            'location' => $dto->location ?? $event->location,
            'description' => $dto->description ?? $event->description,
            'weather_prediction' => $prediction,
        ];

        $event->update($attributes);

        return $event->refresh();
    }

    /**
     * Save Event invitees
     */
    public function saveEventInvitees(Event $event, array $invitees): void
    {
        $event->invitees()->attach($invitees);
    }

    /**
     * Update Event Invites
     */
    public function updateEventInvitees(Event $event, array $invitees): void
    {
        $event->invitees()->sync($invitees);
    }

    /**
     * Get all events between date/time interval
     */
    public function getEventsByInterval(string $start, string $end, int $perPage = 10): array
    {
        return $this->query()->whereBetween('event_date', [$start, $end])
            ->orderBy('event_date')
            ->paginate($perPage)
            ->toArray();
    }
}
