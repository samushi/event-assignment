<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Dto\EventDto;
use App\Domain\Event\Models\Event;
use App\Support\Actions\ActionFactory;
use ReflectionException;

class GetEventAction extends ActionFactory
{
    /**
     * Get Event
     *
     * @throws ReflectionException
     */
    protected function handle(Event $event): array
    {
        return EventDto::fromArray($event->toArray())->toArray();
    }
}
