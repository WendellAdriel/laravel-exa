<?php

namespace Modules\Auth\Support;

enum Roles: string
{
    case VIEWER = 'viewer';
    case REGULAR = 'regular';
    case MANAGER = 'manager';
    case ADMIN = 'admin';
}
