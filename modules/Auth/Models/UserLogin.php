<?php

namespace Modules\Auth\Models;

use Exa\Models\BaseModel;

class UserLogin extends BaseModel
{
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];
}
