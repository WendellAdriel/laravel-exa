<?php

namespace Exa\Support;

use Exa\DTOs\DatatableDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;

readonly class Datatable
{
    public static function manualPaginate(Enumerable $items, int $total, DatatableDTO $dto): array
    {
        $itemsTotal = $items->count();
        $pageCount = $dto->getAll() ? 1 : (int) ceil($itemsTotal / $dto->per_page);
        $data = $dto->getAll()
            ? $items->all()
            : $items->forPage($dto->page, $dto->per_page)->values()->all();

        return [
            'data' => $data,
            'pagination' => [
                'page_count' => $pageCount,
                'total' => $itemsTotal,
                'total_all' => $total,
            ],
        ];
    }

    public static function manualPaginateStream(Enumerable $items, int $total, DatatableDTO $dto): array
    {
        $itemsTotal = $items->count();
        $pageCount = $dto->getAll() ? 1 : (int) ceil($itemsTotal / $dto->per_page);
        $data = $dto->getAll()
            ? $items
            : $items->forPage($dto->page, $dto->per_page)->values();

        return [
            'data' => $data,
            'pagination' => [
                'page_count' => $pageCount,
                'total' => $itemsTotal,
                'total_all' => $total,
            ],
        ];
    }

    public static function applySort(Enumerable $list, DatatableDTO $dto): Enumerable
    {
        if (empty($dto->sort_field)) {
            return $list->values();
        }

        $sorted = $dto->sort_order === SortOption::ASC->value
            ? $list->sortBy($dto->sort_field, SORT_NATURAL | SORT_FLAG_CASE)
            : $list->sortByDesc($dto->sort_field, SORT_NATURAL | SORT_FLAG_CASE);

        return $sorted->values();
    }

    public static function applyFilter(Enumerable $list, DatatableDTO $dto, array $fieldsToSearch): Enumerable
    {
        if (empty($dto->search) || empty($fieldsToSearch)) {
            return $list;
        }

        $filtered = $list->filter(function ($item) use ($dto, $fieldsToSearch) {
            foreach ($fieldsToSearch as $field) {
                $itemArray = $item instanceof Model
                    ? $item->toArray()
                    : json_decode(json_encode($item), true);

                $found = stripos($itemArray[$field], $dto->search) !== false;
                if ($found) {
                    return true;
                }
            }

            return false;
        });

        return $filtered->values();
    }
}
