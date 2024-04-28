<?php

declare(strict_types=1);

namespace Exa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use CommonQueries,
        LogChanges,
        SoftDeletes,
        UserActions;
}
