<?php

namespace App\Providers;

use DataDog\DogStatsd;
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
        $this->app->singleton(
            DogStatsd::class,
            function() {
                return new DogStatsd([
                    'api_key' => $this->app['config']->get('services.datadog.api_key'),
                    'app_key' => $this->app['config']->get('services.datadog.app_key')
                ]);
            }
        );
    }
}
