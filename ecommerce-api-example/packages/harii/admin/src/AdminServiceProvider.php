<?php

namespace Harii\Admin;
 
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services. 
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([__DIR__.'/migrations' => base_path('database/migrations')]);
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
