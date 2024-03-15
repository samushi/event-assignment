<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Models\Event;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;

class DeleteEventAction extends ActionFactory
{
    protected function handle(Event $event): void
    {
        DB::transaction(fn () => $event->delete());
    }
}
