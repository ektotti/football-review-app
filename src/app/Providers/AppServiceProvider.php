<?php

namespace App\Providers;

use App\Repositories\ImageRepositoryInterface;
use App\Repositories\imageRepositoryInLocal;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\FixtureRepositoryInterface;
use App\Repositories\FixtureRepository;
use App\UseCase\GetFixturesInfo;
use Illuminate\Http\Resources\Json\Resource;
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

        app()->bind(ImageRepositoryInterface::class, function () {
            if(env('APP_ENV') === 'local'){
                return new ImageRepositoryInLocal;
            } else {
                return new ImageRepositoryInS3;
            }
        });

        app()->bind(PostRepositoryInterface::class, function () {
            return new PostRepository;
        });

        app()->bind(FixtureRepositoryInterface::class, function () {
            return new FixtureRepository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (env('APP_ENV')==='product') {
        //     \URL::forceScheme('https');
        // }
        Resource::withoutWrapping();
    }
}
