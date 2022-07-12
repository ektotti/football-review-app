<?php

namespace App\Providers;

use App\UseCase\GetFixturesInfo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(GetFixturesInfo::class, function () {
            return new GetFixturesInfo;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \URL::forceScheme('https');
    }
}
