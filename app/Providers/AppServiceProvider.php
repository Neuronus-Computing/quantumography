<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExternalAuthService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ExternalAuthService::class, function ($app) {
            return new ExternalAuthService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
