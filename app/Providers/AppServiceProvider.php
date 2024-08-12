<?php

namespace App\Providers;

use App\Http\Service\Interface\studentServiceInterface;
use app\Http\Service\StudentService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(
         studentServiceInterface::class,
         StudentService::class
      );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
