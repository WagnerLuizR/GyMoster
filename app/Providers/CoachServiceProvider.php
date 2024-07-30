<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CoachService;

class CoachServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CoachService::class, function ($app) {
            return new CoachService(new \App\Repositories\CoachRepository);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
