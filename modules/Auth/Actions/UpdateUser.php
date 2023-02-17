<?php

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Models\User;

final class UpdateUser
{
    public function handle(string $uuid, UpdateUserDTO $dto): User
    {
        // TODO
    }
}
