<?php

namespace Exa\Models;

use Exa\Support\ChangeActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogChanges
{
    public bool $disableChangeLogs = false;

    public bool $logCreateEvent = true;

    public bool $logUpdateEvent = true;

    public bool $logDeleteEvent = true;

    public static function bootLogsChanges()
    {
        static::saved(function (Model $model) {
            if ($model->disableChangeLogs) {
                return;
            }

            if ($model->wasRecentlyCreated && $model->logCreateEvent) {
                static::logChange($model, ChangeActions::CREATE);
            } else {
                if (! $model->getChanges()) {
                    return;
                }
                if ($model->logUpdateEvent) {
                    static::logChange($model, ChangeActions::UPDATE);
                }
            }
        });

        static::deleted(function (Model $model) {
            if ($model->logDeleteEvent) {
                static::logChange($model, ChangeActions::DELETE);
            }
        });
    }

    public static function logChange(Model $model, ChangeActions $action): void
    {
        ChangeLog::query()->create([
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'record_id' => empty($model->id) ? 0 : $model->id,
            'table' => $model->getTable(),
            'action' => $action->value,
            'payload' => $model->toJson(),
            'old_data' => $action !== ChangeActions::CREATE ? json_encode($model->getOriginal()) : null,
            'new_data' => $action !== ChangeActions::DELETE ? json_encode($model->getAttributes()) : null,
            'changed_data' => $action === ChangeActions::UPDATE ? json_encode($model->getChanges()) : null,
        ]);
    }
}
