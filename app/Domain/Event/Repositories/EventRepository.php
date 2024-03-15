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
     * @param User $creator
     * @param CreateEventDto $dto
     * @param array $prediction
     * @return Event|Model
     */
    public function saveEvent(User $creator, CreateEventDto $dto, array $prediction): Event|Model
    {
        $event = $this->getModel()->fill([
            ...$dto->toArray(),
            'weather_prediction' => $prediction
        ]);
        return $creator->event()->save($event);
    }

    /**
     * Save Event invitees
     * @param Event $event
     * @param array $invitees
     * @return void
     */
    public function saveEventInvitees(Event $event, array $invitees): void
    {
        $event->invitees()->attach($invitees);
    }

    /**
     * Get all events between date/time interval
     * @param string $start
     * @param string $end
     * @param int $perPage
     * @return array
     */
    public function getEventsByInterval(string $start, string $end, int $perPage = 10): array
    {
        return $this->query()->whereBetween('event_date', [$start, $end])
            ->orderBy('event_date')
            ->paginate($perPage)
            ->toArray();
    }
}
