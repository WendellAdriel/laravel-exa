<?php

namespace Modules\Auth\Actions;

use Exa\DTOs\DatatableDTO;
use Exa\Support\Datatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;

final readonly class FetchUsersList
{
    public function handle(DatatableDTO $dto): LengthAwarePaginator|Collection
    {
        $query = User::query();
        $query = Datatable::applyFilter($query, $dto, ['email', 'name', 'role']);
        $query = Datatable::applySort($query, $dto);

        return Datatable::applyPagination($query, $dto);
    }
}
