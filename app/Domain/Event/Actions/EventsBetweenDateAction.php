<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Dto\EventsBetweenDateDto;
use App\Domain\Event\Repositories\EventRepository;
use App\Domain\Event\Resources\EventsByIntervalDateResource;
use App\Support\Actions\ActionFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EventsBetweenDateAction extends ActionFactory
{
    public function __construct(
        private readonly EventRepository $repository
    ) {
    }

    protected function handle(EventsBetweenDateDto $dto): array
    {
        return DB::transaction(
            fn () => EventsByIntervalDateResource::make(
                $this->getEvents($dto->start, $dto->end, $dto->perPage)
            )->resolve()
        );
    }

    /**
     * Get all events
     */
    private function getEvents(string $start, string $end, int $perPage): LengthAwarePaginator
    {
        return $this->repository->getEventsByInterval($start, $end, $perPage ?: 10);
    }
}
