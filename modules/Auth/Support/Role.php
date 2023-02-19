<?php

namespace Modules\Auth\Support;

enum Role: string
{
    case VIEWER = 'viewer';
    case REGULAR = 'regular';
    case MANAGER = 'manager';
    case ADMIN = 'admin';
}
