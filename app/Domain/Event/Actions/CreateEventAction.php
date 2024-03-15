<?php

namespace App\Domain\Event\Actions;

use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Event\Models\Event;
use App\Domain\Event\Notifications\Invited;
use App\Domain\Event\Repositories\EventRepository;
use App\Domain\Weather\Services\WeatherService;
use App\Support\Actions\ActionFactory;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateEventAction extends ActionFactory
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EventRepository $eventRepository,
        private readonly WeatherService $weatherService
    ) {
    }

    protected function handle(User $creator, CreateEventDto $dto): string|Exception
    {
        return DB::transaction(function () use ($creator, $dto) {
            // Sent Event Invitees
            $event = $this->saveEventInvitees(
                $this->createEvent($creator, $dto),
                $dto
            );

            return __('Event (:event) Created Successfully', [
                'event' => optional($event)->title,
            ]);
        });
    }

    /**
     * Create Event
     *
     * @throws Exception
     */
    private function createEvent(User $creator, CreateEventDto $dto): Event
    {
        if (! $prediction = $this->weatherService->prediction($dto)) {
            throw new Exception('Something is wrong with weather service');
        }

        return $this->eventRepository->saveEvent($creator, $dto, $prediction);
    }

    /**
     * Save Event Invitees
     */
    private function saveEventInvitees(Event $event, CreateEventDto $dto): Event
    {
        // Get invitees
        $invitees = $this->userRepository->findAllByEmail($dto->invitees);

        // Get invitees id
        $inviteesId = $invitees->pluck('id')->toArray();

        // Create Event Invitees
        $this->eventRepository->saveEventInvitees($event, $inviteesId);

        // Sent invitation emails to invitees
        $event->invitees->each(fn ($invitee) => $invitee->notify(new Invited($invitee, $event)));

        return $event;
    }
}
