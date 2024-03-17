<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Models\Event;
use App\Domain\Event\Resources\EventResource;
use App\Support\Actions\ActionFactory;

class GetEventAction extends ActionFactory
{
    /**
     * Get Event
     */
    protected function handle(Event $event): array
    {
        return EventResource::make($event)->resolve();
    }
}
