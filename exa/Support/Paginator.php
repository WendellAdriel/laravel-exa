<?php

namespace Exa\Support;

use Exa\DTOs\DatatableDTO;
use Illuminate\Support\Enumerable;

readonly class Paginator
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
            'metadata' => [
                'pagination' => [
                    'page_count' => $pageCount,
                    'total' => $itemsTotal,
                    'total_all' => $total,
                ],
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
            'metadata' => [
                'pagination' => [
                    'page_count' => $pageCount,
                    'total' => $itemsTotal,
                    'total_all' => $total,
                ],
            ],
        ];
    }
}
