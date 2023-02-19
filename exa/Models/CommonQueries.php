<?php

namespace Exa\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Enumerable;

trait CommonQueries
{
    public const ALL_COLUMNS = ['*'];

    public const COMPARE_IN = 'IN';

    public static function getAll(array $columns = self::ALL_COLUMNS): Collection
    {
        return self::newQueryBuilder($columns)->get();
    }

    public static function getAllWith(array $columns = self::ALL_COLUMNS, array $with = []): Collection
    {
        return self::newQueryBuilder($columns)->with($with)->get();
    }

    public static function getAllBy(string $attribute, mixed $value, string $compareType = '=', bool $withTrash = false): Collection
    {
        return self::getByParamsBase([[$attribute, $value, $compareType]], $compareType, $withTrash)->get();
    }

    public static function getAllByWith(string $attribute, mixed $value, string $compareType = '', bool $withTrash = false, array $with = []): Collection
    {
        return self::getByParamsBase([[$attribute, $value, $compareType]], $compareType, $withTrash)->with($with)->get();
    }

    public static function getBy(string $attribute, mixed $value, string $compareType = '=', bool $withTrash = false): ?self
    {
        return self::getByParamsBase([[$attribute, $value, $compareType]], $compareType, $withTrash)->first();
    }

    public static function getByOrFail(string $attribute, $value, string $compareType = '=', bool $withTrash = false): self
    {
        return self::getByParamsBase([[$attribute, $value, $compareType]], $compareType, $withTrash)->firstOrFail();
    }

    public static function getByParams(array $params, string $compareType = '=', bool $withTrash = false): ?self
    {
        return self::getByParamsBase($params, $compareType, $withTrash)->first();
    }

    public static function getByParamsOrFail(array $params, string $compareType = '=', bool $withTrash = false): self
    {
        return self::getByParamsBase($params, $compareType, $withTrash)->firstOrFail();
    }

    public static function getAllByParams(array $params, string $compareType = '=', bool $withTrash = false): Collection
    {
        return self::getByParamsBase($params, $compareType, $withTrash)->get();
    }

    public static function updateBy(string $attribute, mixed $value, array $updateFields): int
    {
        $formattedValue = is_array($value) || $value instanceof Enumerable ? $value : [$value];

        return self::newQueryBuilder()
            ->whereIn($attribute, $formattedValue)
            ->update($updateFields);
    }

    public static function deleteBy(string $attribute, mixed $value): mixed
    {
        $formattedValue = is_array($value) || $value instanceof Enumerable ? $value : [$value];

        return self::newQueryBuilder()
            ->whereIn($attribute, $formattedValue)
            ->delete();
    }

    public static function getModelTable(): string
    {
        return (new static)->getTable();
    }

    private static function getByParamsBase(array $params, string $defaultCompareType = '=', bool $withTrashed = false): Builder
    {
        $query = self::newQueryBuilder();
        foreach ($params as $param) {
            $compareType = count($param) === 2 ? $defaultCompareType : $param[2];
            $query = (mb_strtoupper($compareType) === self::COMPARE_IN)
                ? $query->whereIn($param[0], $param[1])
                : $query->where($param[0], $compareType, $param[1]);
        }

        return $withTrashed ? $query->withTrashed() : $query;
    }

    /**
     * Builds a new query
     *
     * @param  array|array<string>|string  $columns
     */
    private static function newQueryBuilder(...$columns): Builder
    {
        if (count($columns) === 1 && is_array($columns[0])) {
            $columns = $columns[0];
        }

        if (empty($columns)) {
            $columns = [self::ALL_COLUMNS];
        }

        return self::query()->select(...$columns);
    }
}
