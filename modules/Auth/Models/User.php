<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Exa\Models\CommonQueries;
use Exa\Models\HasUuidField;
use Exa\Models\LogChanges;
use Exa\Models\UserActions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Support\Role;
use Modules\Auth\Traits\HasRole;
use Override;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class User extends Authenticatable implements JWTSubject
{
    use CommonQueries;
    use HasFactory;
    use HasRole;
    use HasUuidField;
    use LogChanges;
    use Notifiable;
    use SoftDeletes;
    use UserActions;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'email_verified_at',
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
        'role' => Role::class,
        'active' => 'boolean',
    ];

    protected $attributes = [
        'active' => true,
        'role' => Role::REGULAR,
    ];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    #[Override]
    protected static function booted(): void
    {
        self::addGlobalScope(
            'active-users',
            fn (Builder $builder) => $builder->where('active', true)
        );
    }
}
