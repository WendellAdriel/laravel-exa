<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Exa\Models\BaseModel;

class UserLogin extends BaseModel
{
    public bool $disableChangeLogs = true;

    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];
}
