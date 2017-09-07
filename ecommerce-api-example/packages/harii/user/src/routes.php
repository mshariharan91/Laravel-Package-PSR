<?php

global $app;

$api = $app->make(Dingo\Api\Routing\Router::class);


		
$api->version('v1', function ($api) {
$api->group(
			['middleware' => ['jwt.auth','user.auth']],
		function() use($api)  {
	$api->get('/products', [
		'uses' => 'Harii\User\ProductController@getProductList',
	]);
	
	$api->post('/cart', [
				'uses' => 'Harii\User\Cart\CartController@postCart',
			]);
	
	$api->get('/cart', [
				'uses' => 'Harii\User\Cart\CartController@getCart',
			]);		
			
	});	
});		

 


