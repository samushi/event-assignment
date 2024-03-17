<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Dto\GroupEventsByLocationDto;
use App\Domain\Event\Repositories\EventRepository;
use App\Domain\Event\Resources\GroupedEventsResource;
use App\Support\Actions\ActionFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GroupEventsByLocationAction extends ActionFactory
{
    public function __construct(
        private readonly EventRepository $eventRepository
    ) {
    }

    protected function handle(GroupEventsByLocationDto $dto): array
    {
        return DB::transaction(function () use ($dto) {
            return GroupedEventsResource::make($this->getGroupEventsByLocation($dto))->resolve();
        });
    }

    /**
     * Get Events grouped by location
     */
    private function getGroupEventsByLocation(GroupEventsByLocationDto $dto): LengthAwarePaginator
    {
        return $this->eventRepository->groupByLocation(
            start: $dto->start,
            end: $dto->end,
            perPage: $dto->perPage
        );
    }
}
