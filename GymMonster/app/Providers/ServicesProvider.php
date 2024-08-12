<?php

namespace App\Providers;

use App\Service\AutorService;
use App\Service\AutorServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
        
    public array $bindings = [
        AutorServiceInterface::class => AutorService::class,
    ];
    
    
    
    
    /**
     * Register services.
   
    public function register(): void
    {
        //
    }
  */
    /**
     * Bootstrap services.
 
    public function boot(): void
    {
        //
    }
        */
}
