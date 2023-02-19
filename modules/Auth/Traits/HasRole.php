<?php

namespace Modules\Auth\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Auth\Support\Role;

trait HasRole
{
    public function isViewer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Role::VIEWER),
        );
    }

    public function isRegular(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Role::REGULAR),
        );
    }

    public function isManager(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Role::MANAGER),
        );
    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Role::ADMIN),
        );
    }

    public function hasRole(Role $role): bool
    {
        return $this->role === $role->value;
    }
}
