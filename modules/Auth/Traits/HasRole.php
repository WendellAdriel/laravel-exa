<?php

namespace Modules\Auth\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Auth\Support\Roles;

trait HasRole
{
    public function isViewer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Roles::VIEWER),
        );
    }

    public function isRegular(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Roles::REGULAR),
        );
    }

    public function isManager(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Roles::MANAGER),
        );
    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasRole(Roles::ADMIN),
        );
    }

    public function hasRole(Roles $role): bool
    {
        return $this->role === $role->value;
    }
}
