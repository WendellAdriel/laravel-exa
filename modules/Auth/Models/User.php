<?php

namespace Modules\Auth\Models;

use Exa\Models\CommonQueries;
use Exa\Models\HasUuidField;
use Exa\Models\LogChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Support\Role;
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
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => true,
        'role' => Role::REGULAR->value,
    ];

    protected static function booted()
    {
        static::addGlobalScope('active-users', fn (Builder $builder) => $builder->where('active', true));
    }
}
