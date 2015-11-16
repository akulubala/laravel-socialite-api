<?php
namespace LaravelSocialiteApi;

use Illuminate\Support\ServiceProvider;

class SocialiteApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.laravel-socialite-api.make', function($app) {
            return $app['LaravelSocialiteApi\Commands\SocialiteMakeCommand'];
        });
        $this->commands('command.laravel-socialite-api.make');

        $this->app->singleton('command.laravel-socialite-api.clear', function($app) {
            return $app['LaravelSocialiteApi\Commands\SocialiteClearCommand'];
        });
        $this->commands('command.laravel-socialite-api.clear');

    }
}
