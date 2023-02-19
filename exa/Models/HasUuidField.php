<?php

namespace Exa\Models;

use Illuminate\Support\Str;

trait HasUuidField
{
    protected string $uuidFieldName = 'uuid';

    public function getUuidFieldName(): ?string
    {
        return $this->uuidFieldName ?? null;
    }

    protected static function bootHasUuidField()
    {
        static::creating(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if ($uuidFieldName && ! isset($model->{$uuidFieldName})) {
                $model->{$uuidFieldName} = Str::uuid()->toString();
            }
        });

        static::saving(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (! empty($uuidFieldName)) {
                $originalUuid = $model->getOriginal($uuidFieldName);
                if ($originalUuid && $originalUuid !== $model->{$uuidFieldName}) {
                    $model->{$uuidFieldName} = $originalUuid;
                }
            }
        });
    }
}
