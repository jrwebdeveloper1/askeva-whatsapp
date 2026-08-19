<?php

namespace Askeva\WhatsApp;

use Illuminate\Support\ServiceProvider;

class AskEvaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/askeva.php', 'askeva');

        $this->app->singleton('askeva', function ($app) {
            return new AskEvaClient(
                config('askeva.base_url'),
                config('askeva.token')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/webhooks.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/askeva.php' => config_path('askeva.php'),
            ], 'askeva-config');
        }
    }
}
