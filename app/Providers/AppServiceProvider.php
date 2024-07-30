<?php

namespace App\Providers;

use App\Service\userService;
use App\Service\userServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      //$this->app->bind(
         //userServiceInterface::class,
         //userService::class
     //);
    }
  
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
