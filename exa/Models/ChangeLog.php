<?php

declare(strict_types=1);

namespace Exa\Models;

use Exa\Support\ChangeAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Models\User;

final class ChangeLog extends Model
{
    use CommonQueries;

    protected $fillable = [
        'user_id',
        'record_id',
        'table',
        'action',
        'payload',
        'old_data',
        'new_data',
        'changed_data',
    ];

    protected $casts = [
        'action' => ChangeAction::class,
        'payload' => 'array',
        'old_data' => 'array',
        'new_data' => 'array',
        'changed_data' => 'array',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
