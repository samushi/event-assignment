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
     * @param array $array
     * @return Builder
     */
    public function with(array $array = []): Builder
    {
        return $this->query()->with($array);
    }

    /**
     * All columns list
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
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     * @return int
     */
    public function update(array $data, int $id, string $attribute = 'id'): int
    {
        return $this->query()
            ->where($attribute, '=', $id)
            ->update($data);
    }

    /**
     * Delete model
     *
     * @param string $id
     * @return int
     */
    public function delete(string $id): int
    {
        return $this->getModel()->destroy($id);
    }

    /**
     * Find by id
     * @param $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * Query builder
     * @return Builder
     */
    protected function query(): Builder
    {
        return $this->getModel()->newQuery();
    }
}
