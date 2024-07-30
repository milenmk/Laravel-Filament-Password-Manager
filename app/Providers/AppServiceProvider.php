<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        // Prevent lazy loading
        Model::shouldBeStrict();

        // Turn morph map enforcement on (new in 8.59.0).
        Relation::requireMorphMap();

        // Map morphs in the standard way.
        Relation::enforceMorphMap(
            [
                'user' => User::class,
            ],
        );
    }
}
