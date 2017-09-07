<?php

namespace Harii\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/cart/migrations' => base_path('database/migrations')]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		include __DIR__.'/routes.php';
    }
}
