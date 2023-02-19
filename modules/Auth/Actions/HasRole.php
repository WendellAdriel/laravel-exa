<?php

namespace Modules\Auth\Actions;

use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

final readonly class HasRole
{
    public function handle(User $user, Role $role): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->hasRole($role);
    }
}
