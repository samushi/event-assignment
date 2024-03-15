<?php

namespace App\Domain\Event\Controllers;

use App\Domain\Event\Actions\CreateEventAction;
use App\Domain\Event\Actions\EventsBetweenDateAction;
use App\Domain\Event\Dto\CreateEventDto;
use App\Domain\Event\Dto\EventsBetweenDateDto;
use App\Domain\Event\Requests\EventCreateRequest;
use App\Domain\Event\Requests\GetEventsByDateRequest;
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
    public function getAllForDate(GetEventsByDateRequest $request): ?Response
    {
        return rescue(
            fn () => $this->success(EventsBetweenDateAction::run(EventsBetweenDateDto::fromRequest($request))),
            $this->throwValidationException()
        );
    }
}
