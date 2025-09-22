<?php

declare(strict_types=1);

namespace Exa\Support;

use Exa\DTOs\DatatableDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class Datatable
{
    public const array ALL_COLUMNS = ['*'];

    public const string DEFAULT_PAGE_NAME = 'page';

    public static function applyPagination(
        Builder $builder,
        DatatableDTO $dto,
        array $columns = self::ALL_COLUMNS,
        string $pageName = self::DEFAULT_PAGE_NAME
    ): LengthAwarePaginator|Collection {
        return $dto->getAll()
            ? $builder->select($columns)->get()
            : $builder->paginate($dto->per_page, $columns, $pageName, $dto->page);
    }

    public static function applySort(Builder $builder, DatatableDTO $dto): Builder
    {
        if ($dto->sort_field === null || $dto->sort_field === '' || $dto->sort_field === '0') {
            return $builder;
        }

        return $dto->sort_order === SortOption::ASC
            ? $builder->orderBy($dto->sort_field)
            : $builder->orderByDesc($dto->sort_field);
    }

    public static function applyFilter(Builder $builder, DatatableDTO $dto, array $fieldsToSearch): Builder
    {
        if ($dto->search === null || $dto->search === '' || $dto->search === '0' || $fieldsToSearch === []) {
            return $builder;
        }

        return $builder->where(function (Builder $query) use ($dto, $fieldsToSearch): void {
            foreach ($fieldsToSearch as $field) {
                $query->orwhere($field, 'LIKE', "%{$dto->search}%");
            }
        });
    }
}
