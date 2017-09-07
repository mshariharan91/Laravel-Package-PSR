<?php

namespace Harii\Auth;

use Harii\Auth\User;
use Harii\Auth\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $e->getResponse();
        }

        try {
            // Attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(
                $this->getCredentials($request)
            )) {
                return $this->onUnauthorized();
            }
        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return $this->onJwtGenerationError();
        }
		 
		
		 
        // All good so return the token
        return $this->onAuthorized($token);
    }
	
	
	
	public function postUserRegister(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|unique:users',
				'password'=>'required|between:6,12|confirmed',
				'password_confirmation'=>'required|between:6,12',
            ]);
        } catch (ValidationException $e) {
            return $e->getResponse();
        }
		
		$requestdata = $request->all();
		$requestdata['password'] = Hash::make($request->get('password'));
		
		$request->merge($requestdata);
		 
        $user = User::create($request->all());
		  

		$role = Role::find($request->get('user_role'));
		$user->roles()->attach(User::UserRole());
		
		return response()->json(["message" => "User has been registered successfully"],201);
    }
	
	public function postAdminRegister(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|unique:users',
				'password'=>'required|between:6,12|confirmed',
				'password_confirmation'=>'required|between:6,12',
            ]);
        } catch (ValidationException $e) {
            return $e->getResponse();
        }
		
		$requestdata = $request->all();
		$requestdata['password'] = Hash::make($request->get('password'));
		
		$request->merge($requestdata);
		 
        $user = User::create($request->all());
		  

		$role = Role::find($request->get('user_role'));
		$user->roles()->attach(User::AdminRole());
		
		return response()->json(["message" => "Admin has been registered successfully"],201);
    }
	
	

    /**
     * What response should be returned on invalid credentials.
     *
     * @return JsonResponse
     */
    protected function onUnauthorized()
    {
        return new JsonResponse([
            'message' => 'invalid_credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * What response should be returned on error while generate JWT.
     *
     * @return JsonResponse
     */
    protected function onJwtGenerationError()
    {
        return new JsonResponse([
            'message' => 'could_not_create_token'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * What response should be returned on authorized.
     *
     * @return JsonResponse
     */
    protected function onAuthorized($token)
    {
		$user = JWTAuth::toUser($token);
		$role = User::find($user->id)->roles[0]->name;
        return new JsonResponse([
			'success' => 'true',
            'message' => 'token_generated',
            'token' => $token,
			'role' => $role
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Invalidate a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteInvalidate()
    {
        $token = JWTAuth::parseToken();

        $token->invalidate();

        return new JsonResponse(['message' => 'token_invalidated']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function patchRefresh()
    {
        $token = JWTAuth::parseToken();

        $newToken = $token->refresh();

        return new JsonResponse([
            'message' => 'token_refreshed',
            'data' => [
                'token' => $newToken
            ]
        ]);
    }

    /**
     * Get authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {
        return new JsonResponse([
            'message' => 'authenticated_user',
            'data' => JWTAuth::parseToken()->authenticate()
        ]);
    }
}
