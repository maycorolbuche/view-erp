<?php

namespace App\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        static::creating(function ($model) {
            $user = auth()->user();
            if ($user) {
                $model->created_by = $user->id_user;
                $model->updated_by = $user->id_user;
            }
        });

        static::updating(function ($model) {
            $user = auth()->user();
            if ($user) {
                $model->updated_by = $user->id_user;
            }
        });
    }
}
