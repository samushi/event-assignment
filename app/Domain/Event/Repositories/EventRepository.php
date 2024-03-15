<?php

namespace App\Domain\Event\Repositories;

use App\Domain\Auth\Models\User;
use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Event\Models\Event;
use App\Support\Repositories;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends Repositories
{
    protected function getModel(): Model
    {
        return new Event();
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
     * Save Event invitees
     */
    public function saveEventInvitees(Event $event, array $invitees): void
    {
        $event->invitees()->attach($invitees);
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
