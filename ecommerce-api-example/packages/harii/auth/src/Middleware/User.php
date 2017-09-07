<?php

namespace Harii\Auth\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Harii\Auth\User as UserModel; 

class User
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        	 
        if (UserModel::find($this->auth->id())->roles[0]->id == 2) {
			return $next($request);           
        }
		
		return response(["message" => "Access denied"], 401);
    }
}
