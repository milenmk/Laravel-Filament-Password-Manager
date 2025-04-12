<?php

declare(strict_types=1);

namespace App\Traits;

trait UserTrait
{
    /**
     * Boot the trait for a model.
     */
    public static function bootUserTrait(): void
    {
        if (auth()->check()) {
            static::creating(function ($model): void {
                $model->user_id = auth()->id();
            });
        }
    }
}
