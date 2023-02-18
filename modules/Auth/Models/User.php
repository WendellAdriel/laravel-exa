<?php

namespace Modules\Auth\Models;

use Exa\Models\CommonQueries;
use Exa\Models\HasUuidField;
use Exa\Models\LogChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Traits\HasRole;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRole,
        HasUuidField,
        LogChanges,
        CommonQueries;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
