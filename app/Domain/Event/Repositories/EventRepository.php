<?php

namespace App\Domain\Event\Repositories;

use App\Domain\Event\Models\Event;
use App\Support\Repositories;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends Repositories
{
    protected function getModel(): Model
    {
        return new Event();
    }
}
