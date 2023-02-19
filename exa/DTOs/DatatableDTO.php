<?php

namespace Exa\DTOs;

use Exa\Support\SortOption;
use Illuminate\Validation\Rules\Enum;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class DatatableDTO extends ValidatedDTO
{
    public const PER_PAGE_ALL = 'all';

    public int $page;

    public int|string $per_page;

    public ?string $sort_field;

    public ?string $sort_order;

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
            'sort_order' => null,
            'search' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            'page' => new IntegerCast(),
        ];
    }
}
