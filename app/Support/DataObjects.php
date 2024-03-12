<?php

declare(strict_types=1);

namespace App\Support;

use Closure;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

abstract class DataObjects
{
    /**
     * Get validated all data and initialize with props
     * @param FormRequest $request
     * @return DataObjects
     * @throws ReflectionException
     */
    public static function fromRequest(FormRequest $request): static
    {
        return static::makeInstanceArgs($request->validated());
    }

    /**
     * Get from array list and initialize with props
     * @param array $data
     * @return static
     * @throws ReflectionException
     */
    public static function fromArray(array $data): static
    {
        return static::makeInstanceArgs($data);
    }

    /**
     * From collection or list array
     * @param array $data
     * @return Collection
     */
    public static function fromList(array $data): Collection
    {
        return Collection::make($data)->transform(fn ($item) => static::makeInstanceArgs($item)->toArray());
    }

    /**
     * Transform array list
     * @param array $data
     * @param Closure|null $transform
     * @return Collection
     */
    public static function fromListTransform(array $data, ?Closure $transform = null): Collection
    {
        return self::fromList($data)->collect()->transform($transform);
    }

    /**
     * Paginate the collection into a simple paginator
     * @param array $data
     * @param Closure|null $transform
     * @param int $perPage
     * @param string $pageName
     * @param int|null $page
     * @param array $options
     * @return Paginator
     */
    public static function paginate(array $data, ?Closure $transform = null, int $perPage = 15, string $pageName = 'page', ?int $page = null, array $options = []): Paginator
    {
        // Resolve Current Page
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        // Transform to the current required data
        $results = Collection::make($data)
            ->transform(fn ($item) => static::makeInstanceArgs($item)->toArray());

        // Transform from secondary data object
        $results = $transform ? $results->transform($transform) : $results;

        // Slice the results
        $results = $results->slice(($page - 1) * $perPage)
            ->take($perPage + 1);

        // Create simple options for paginator
        $options += [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName
        ];

        return new Paginator($results, $perPage, $page, $options);
    }

    /**
     * Make object to array
     * @param array $excepts
     * @return array
     */
    public function toArray(array $excepts = []): array
    {
        return $this->excepts($excepts, $this->arrayKeysFromCamelToSnake());
    }

    /**
     * Make Array to the Collections
     * @param array $excepts
     * @return Collection
     */
    public function toCollection(array $excepts = []): Collection
    {
        return Collection::make($this->toArray($excepts));
    }

    /**
     * Make instance from array list
     * @param array $data
     * @return $this
     * @throws ReflectionException
     */
    private static function makeInstanceArgs(array $data): static
    {
        return static::getReflectionClass()->newInstanceArgs(
            array_map(
                fn ($param) => isset($data[Str::snake($param->getName())]) ? $data[Str::snake($param->getName())] : null,
                static::getClassProperties()
            )
        );
    }

    /**
     * Get Reflection class
     * @return ReflectionClass
     */
    private static function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }

    /**
     * Get Reflection class
     * @return ReflectionMethod
     */
    private static function getStaticContruction(): ReflectionMethod
    {
        return static::getReflectionClass()->getConstructor();
    }

    /**
     * Get Class parameters
     * @return ReflectionParameter[]
     */
    private static function getClassProperties(): array
    {
        return static::getStaticContruction()->getParameters();
    }

    /**
     * Convert all camel properties to the snake
     * @return array
     */
    private function arrayKeysFromCamelToSnake(): array
    {
        $props = get_object_vars($this);
        $newKeys = array_map(fn ($key) => Str::snake($key), array_keys($props));
        return array_combine($newKeys, $props);
    }

    /**
     * Excepts from data
     * @param array $excepts
     * @param array $props
     * @return array|null
     */
    private function excepts(array $excepts = [], array $props = []): ?array
    {
        foreach ($excepts as $except) {
            Arr::pull($props, $except);
        }
        return $props;
    }

}
