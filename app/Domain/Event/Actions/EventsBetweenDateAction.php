<?php

namespace App\Domain\Event\Actions;

use App\Domain\Event\Dto\EventsBetweenDateDto;
use App\Domain\Event\Repositories\EventRepository;
use App\Support\Actions\ActionFactory;

class EventsBetweenDateAction extends ActionFactory
{
    public function __construct(
        private readonly EventRepository $repository
    )
    {
    }

    protected function handle(EventsBetweenDateDto $dto): array
    {
        $perPage = $dto->perPage ?: 10;
        return $this->repository->getEventsByInterval($dto->start, $dto->end, $perPage);
    }
}
