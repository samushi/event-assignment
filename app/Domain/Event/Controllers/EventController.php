<?php

namespace App\Domain\Event\Controllers;

use App\Domain\Event\Repositories\EventRepository;
use App\Domain\Event\Requests\EventCreateRequest;
use App\Support\ApiControllers;

class EventController extends ApiControllers
{
    public function __construct(
      private EventRepository $eventRepository
    ){}

    public function create(EventCreateRequest $request)
    {
        // TODO: Implement create() method.
    }
}
