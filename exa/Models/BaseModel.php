<?php

declare(strict_types=1);

namespace Exa\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use CommonQueries;
    use LogChanges;
    use UserActions;
}
