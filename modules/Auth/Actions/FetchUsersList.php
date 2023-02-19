<?php

namespace Modules\Auth\Actions;

use Exa\DTOs\DatatableDTO;
use Exa\Support\Datatable;
use Modules\Auth\Models\User;

final readonly class FetchUsersList
{
    public function handle(DatatableDTO $dto): array
    {
        $users = User::getAll();
        $filtered = Datatable::applyFilter($users, $dto, ['email', 'name', 'role']);
        $result = Datatable::applySort($filtered, $dto);

        return Datatable::manualPaginate($result, $users->count(), $dto);
    }
}
