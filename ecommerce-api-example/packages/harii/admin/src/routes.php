<?php

 global $app; 

$api = $app->make(Dingo\Api\Routing\Router::class);
$api->version('v1', function ($api) {
	resource($api,'admin/user', 'Harii\Admin\User\UserController');
	resource($api,'admin/product', 'Harii\Admin\Product\ProductController');
});
function resource($api,$uri, $controller)
{
		$api->group(
			['middleware' => ['jwt.auth','admin.auth']],
		function() use($api,$uri,$controller)  {
			$api->get($uri, $controller.'@index');
			$api->post($uri, $controller.'@store');
			$api->get($uri.'/{id}', $controller.'@show');
			$api->put($uri.'/{id}', $controller.'@update');
			$api->patch($uri.'/{id}', $controller.'@update');
			$api->delete($uri.'/{id}', $controller.'@destroy');
		});
	 
}
