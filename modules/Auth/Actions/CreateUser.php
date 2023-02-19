<?php

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\Models\User;

final readonly class CreateUser
{
    public function handle(CreateUserDTO $dto): User
    {
        $user = $dto->toModel(User::class);
        $user->save();

        return $user;
    }
}
