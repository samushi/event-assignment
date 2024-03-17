<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repositories
{
    abstract protected function getModel(): Model;

    /**
     * Eager loading
     */
    public function with(array $array = []): Builder
    {
        return $this->query()->with($array);
    }

    /**
     * Where Between date
     */
    protected function betweenDate(string $start, string $end, string $column = 'event_date'): Builder
    {
        return $this->query()->whereBetween($column, [$start, $end]);
    }

    /**
     * All columns list
     *
     * @return Builder[]|Collection|Model
     */
    public function all(array $columns = ['*']): Model|Collection|array
    {
        return $this->query()->get($columns);
    }

    /**
     * Create new model
     */
    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    /**
     * Update the model
     */
    public function update(array $data, int $id, string $attribute = 'id'): int
    {
        return $this->query()
            ->where($attribute, '=', $id)
            ->update($data);
    }

    /**
     * Delete model
     */
    public function delete(string $id): int
    {
        return $this->getModel()->destroy($id);
    }

    /**
     * Find by id
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * Query builder
     */
    protected function query(): Builder
    {
        return $this->getModel()->newQuery();
    }
}
