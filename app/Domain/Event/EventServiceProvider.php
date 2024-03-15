<?php

namespace App\Domain\Event;

use App\Support\AbstractServiceProvider;

class EventServiceProvider extends AbstractServiceProvider
{
    public function setDomain(): string
    {
        return 'Event';
    }
}
