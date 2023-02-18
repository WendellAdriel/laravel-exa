<?php

namespace Exa\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use CommonQueries,
        LogChanges;
}
