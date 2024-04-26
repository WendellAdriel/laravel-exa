<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

enum Role: string
{
    case VIEWER = 'viewer';
    case REGULAR = 'regular';
    case MANAGER = 'manager';
    case ADMIN = 'admin';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
