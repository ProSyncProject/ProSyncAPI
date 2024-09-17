<?php

namespace App\Traits;

trait HasUniqueId
{
    protected static function bootHasUniqueId(): void
    {
        static::creating(function ($model) {
            $model->unique_id = nanoId();
        });
    }
}
