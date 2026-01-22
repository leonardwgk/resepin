<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This tells Laravel: "I am behind a proxy, always use HTTPS for links and forms"
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
