<?php

namespace Exa\Models;

use Exa\Support\ChangeAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogChanges
{
    public bool $disableChangeLogs = false;

    public bool $logCreateEvent = true;

    public bool $logUpdateEvent = true;

    public bool $logDeleteEvent = true;

    public static function bootLogChanges()
    {
        static::saved(function (Model $model) {
            if ($model->disableChangeLogs) {
                return;
            }

            if ($model->wasRecentlyCreated && $model->logCreateEvent) {
                static::logChange($model, ChangeAction::CREATE);
            } else {
                if (! $model->getChanges()) {
                    return;
                }
                if ($model->logUpdateEvent) {
                    static::logChange($model, ChangeAction::UPDATE);
                }
            }
        });

        static::deleted(function (Model $model) {
            if ($model->disableChangeLogs) {
                return;
            }

            if ($model->logDeleteEvent) {
                static::logChange($model, ChangeAction::DELETE);
            }
        });
    }

    public static function logChange(Model $model, ChangeAction $action): void
    {
        ChangeLog::query()->create([
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'record_id' => empty($model->id) ? 0 : $model->id,
            'table' => $model->getTable(),
            'action' => $action->value,
            'payload' => $model->toJson(),
            'old_data' => $action !== ChangeAction::CREATE ? json_encode($model->getOriginal()) : null,
            'new_data' => $action !== ChangeAction::DELETE ? json_encode($model->getAttributes()) : null,
            'changed_data' => $action === ChangeAction::UPDATE ? json_encode($model->getChanges()) : null,
        ]);
    }
}
