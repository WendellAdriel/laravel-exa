<?php

declare(strict_types=1);

namespace Exa\DTOs;

use Exa\Support\SortOption;
use Illuminate\Validation\Rules\Enum;
use OpenApi\Attributes as OA;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

#[OA\Schema(
    schema: 'pagination-links',
    properties: [
        new OA\Property(property: 'first', type: 'string'),
        new OA\Property(property: 'last', type: 'string'),
        new OA\Property(property: 'prev', type: 'string'),
        new OA\Property(property: 'next', type: 'string'),
    ],
)]

#[OA\Schema(
    schema: 'pagination-meta',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer'),
        new OA\Property(property: 'from', type: 'integer'),
        new OA\Property(property: 'last_page', type: 'integer'),
        new OA\Property(property: 'path', type: 'string'),
        new OA\Property(property: 'per_page', type: 'integer'),
        new OA\Property(property: 'to', type: 'integer'),
        new OA\Property(property: 'total', type: 'integer'),
        new OA\Property(
            property: 'links',
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'url', type: 'string'),
                    new OA\Property(property: 'label', type: 'string'),
                    new OA\Property(property: 'active', type: 'boolean'),
                ],
            ),
        ),
    ],
)]
class DatatableDTO extends ValidatedDTO
{
    public const PER_PAGE_ALL = 'all';

    public int $page;

    public int|string $per_page;

    public ?string $sort_field;

    public ?SortOption $sort_order;

    public ?string $search;

    public function getAll(): bool
    {
        return $this->per_page === self::PER_PAGE_ALL;
    }

    protected function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer'],
            'per_page' => ['sometimes'],
            'sort_field' => ['sometimes', 'string'],
            'sort_order' => ['sometimes', 'string', new Enum(SortOption::class)],
            'search' => ['sometimes', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'page' => 1,
            'per_page' => 20,
            'sort_field' => null,
            'sort_order' => SortOption::ASC,
            'search' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            'page' => new IntegerCast(),
            'sort_order' => new EnumCast(SortOption::class),
        ];
    }
}
