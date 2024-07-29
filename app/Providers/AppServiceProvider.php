<?php

namespace App\Providers;

use App\Service\AutorService;
use App\Service\AutorServiceInterface;
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
         //AutorServiceInterface::class,
         //AutorService::class
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
