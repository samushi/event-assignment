<?php

namespace App\Domain\Event\Actions;

use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Event\Dto\UpdateRequestEventDto;
use App\Domain\Event\Models\Event;
use App\Domain\Event\Notifications\Invited;
use App\Domain\Event\Notifications\InvitedCanceled;
use App\Domain\Event\Repositories\EventRepository;
use App\Domain\Weather\Services\WeatherService;
use App\Support\Actions\ActionFactory;
use Exception;
use Illuminate\Support\Facades\DB;
use ReflectionException;

class UpdateEventAction extends ActionFactory
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EventRepository $eventRepository,
        private readonly WeatherService $weatherService
    ) {
    }

    protected function handle(Event $event, UpdateRequestEventDto $dto): array
    {
        return DB::transaction(function () use ($event, $dto) {
            // Event Update
            $event = $this->updateEventInvitees(
                $this->updateEvent($event, $dto),
                $dto
            );

            // Refresh event
            return $event->refresh()->toArray();
        });
    }

    /**
     * Update Event invitees
     *
     * @throws ReflectionException
     * @throws Exception
     */
    private function updateEvent(Event $event, UpdateRequestEventDto $dto): Event
    {
        $location = $dto->location ?: $event->location;
        $eventDate = $dto->eventDate ?: $event->event_date;

        if (! $prediction = $this->weatherService->prediction($location, $eventDate)) {
            throw new Exception('Something is wrong with weather service');
        }

        return $this->eventRepository->updateEvent($event, $dto, $prediction);
    }

    /**
     * Update Invitees
     */
    private function updateEventInvitees(Event $event, UpdateRequestEventDto $dto): Event
    {
        // Get id's from invitees
        $invitees = $this->getInvites($dto->invitees);

        // Get old invitees from Db
        $oldInvitees = $this->getOldInvitees($event);

        // Get New Invites
        $newInvitees = $this->getNewInvitees($oldInvitees, $invitees);

        // Get Old Invitees but removed from new invitees
        $removedOldInvitees = $this->getRemovedInvitees($newInvitees, $invitees, $oldInvitees);

        // Create Event Invitees
        $this->eventRepository->updateEventInvitees($event, $invitees);

        // Send invitation email to the new invitees
        $this->userRepository->findAllById($newInvitees)->each(fn ($invitee) => $invitee->notify(new Invited($invitee, $event)));

        // Sent invitation for canceled invitation
        $this->userRepository->findAllById($removedOldInvitees)->each(fn ($invitee) => $invitee->notify(new InvitedCanceled($invitee, $event)));

        return $event;
    }

    /**
     * Get Invites
     */
    private function getInvites(array $emails): array
    {
        return $this->userRepository
            ->findAllByEmail($emails)
            ->pluck('id')
            ->toArray();
    }

    /**
     * Get old invitees
     */
    private function getOldInvitees(Event $event): array
    {
        return $event->invitees->pluck('id')->toArray();
    }

    /**
     * Get New Invitees
     */
    private function getNewInvitees(array $oldInvitees, array $invitees): array
    {
        return array_values(array_diff($invitees, $oldInvitees));
    }

    /**
     * Get Removed invites
     */
    private function getRemovedInvitees(array $newInvitees, array $invitees, array $oldInvitees): array
    {
        $oldButUsedInvitees = array_diff($invitees, $newInvitees);

        return array_diff($oldInvitees, $oldButUsedInvitees);
    }
}
