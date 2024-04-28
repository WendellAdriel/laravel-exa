<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Exa\Models\BaseModel;

final class UserLogin extends BaseModel
{
    public bool $disableChangeLogs = true;

    public bool $disableUserActions = true;

    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];
}
