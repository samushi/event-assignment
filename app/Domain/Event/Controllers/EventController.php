<?php

namespace App\Domain\Event\Controllers;

use App\Domain\Event\Actions\CreateEventAction;
use App\Domain\Event\Actions\DeleteEventAction;
use App\Domain\Event\Actions\EventsBetweenDateAction;
use App\Domain\Event\Actions\GetEventAction;
use App\Domain\Event\Actions\GroupEventsByLocationAction;
use App\Domain\Event\Actions\UpdateEventAction;
use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Event\Dto\EventsBetweenDateDto;
use App\Domain\Event\Dto\GroupEventsByLocationDto;
use App\Domain\Event\Dto\UpdateRequestEventDto;
use App\Domain\Event\Models\Event;
use App\Domain\Event\Requests\EventCreateRequest;
use App\Domain\Event\Requests\GetEventsByDateRequest;
use App\Domain\Event\Requests\GroupEventsByLocationRequest;
use App\Domain\Event\Requests\UpdateEventRequest;
use App\Support\ApiControllers;
use Exception;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;

class EventController extends ApiControllers
{
    /**
     * Create Event
     *
     * @throws ReflectionException
     * @throws Exception
     */
    public function create(EventCreateRequest $request): ?Response
    {
        return rescue(
            fn () => $this->successWithMessage(
                CreateEventAction::run(
                    $request->user(),
                    CreateEventDto::fromRequest($request)
                )
            ),
            $this->throwValidationException()
        );
    }

    /**
     * Get event
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function get(Event $event): ?Response
    {
        return rescue(
            fn () => $this->success(GetEventAction::run($event)),
            $this->throwValidationException()
        );
    }

    /**
     * Delete Event
     *
     * @throws Exception
     */
    public function delete(Event $event): ?Response
    {
        return rescue(
            fn () => $this->noContentClosure(fn () => DeleteEventAction::run($event)),
            $this->throwValidationException()
        );
    }

    /**
     * Update Event
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws ReflectionException
     * @throws Exception
     */
    public function update(UpdateEventRequest $request, Event $event): ?Response
    {
        return rescue(
            fn () => $this->success(
                UpdateEventAction::run($event, UpdateRequestEventDto::fromRequest($request))
            ),
            $this->throwValidationException()
        );
    }

    /**
     * Get all events for specific date interval
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws ReflectionException
     * @throws Exception
     */
    public function getAllBetweenDate(GetEventsByDateRequest $request): ?Response
    {
        return rescue(
            fn () => $this->success(
                EventsBetweenDateAction::run(EventsBetweenDateDto::fromRequest($request))
            ),
            $this->throwValidationException()
        );
    }

    /**
     * Get Events by data interval and show by locations
     *
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws ReflectionException
     * @throws Exception
     */
    public function getAllEventLocationsByDateInterval(GroupEventsByLocationRequest $request): ?Response
    {
        return rescue(
            fn () => $this->success(
                GroupEventsByLocationAction::run(GroupEventsByLocationDto::fromRequest($request))
            ),
            $this->throwValidationException()
        );
    }
}
