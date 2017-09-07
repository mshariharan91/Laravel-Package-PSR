<?php

namespace Harii\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->app->routeMiddleware([
            'admin.auth' => Middleware\Admin::class,
			'user.auth' => Middleware\User::class
        ]);
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
