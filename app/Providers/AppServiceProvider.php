<?php

namespace App\Providers;

use App\Models\Courrier;
use App\Observers\CourrierObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

   
    public function boot(): void
    {
     
    Courrier::observe(CourrierObserver::class);
    }
    
    }

