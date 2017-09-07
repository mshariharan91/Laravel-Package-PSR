<?php

global $app;

$api = $app->make(Dingo\Api\Routing\Router::class);


		
$api->version('v1', function ($api) {
	 
    $api->post('/auth/login', [
        'as' => 'api.auth.login',
        'uses' => 'Harii\Auth\AuthController@postLogin',
    ]);
	
	$api->post('/auth/user/register', [
        'as' => 'api.auth.register',
        'uses' => 'Harii\Auth\AuthController@postUserRegister',
    ]);
	
	$api->post('/auth/admin/register', [
        'as' => 'api.auth.register',
        'uses' => 'Harii\Auth\AuthController@postAdminRegister',
    ]);


    $api->group([
        'middleware' => 'api.auth',
    ], function ($api) {
        
        $api->get('/auth/user', [
            'uses' => 'Harii\Auth\AuthController@getUser',
            'as' => 'api.auth.user'
        ]);
        $api->patch('/auth/refresh', [
            'uses' => 'Harii\Auth\AuthController@patchRefresh',
            'as' => 'api.auth.refresh'
        ]);
        $api->delete('/auth/invalidate', [
            'uses' => 'Harii\Auth\AuthController@deleteInvalidate',
            'as' => 'api.auth.invalidate'
        ]);
    });
});