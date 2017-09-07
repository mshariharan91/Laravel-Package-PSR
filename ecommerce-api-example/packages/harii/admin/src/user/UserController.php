<?php

namespace Harii\Admin\User;

use Harii\Auth\User;
use Harii\Auth\Role; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
	public function __construct()
    {
    }
	
    public function index()
	{
		return User::all();
	}
	
	public function show($id)
    {
        $user = User::find($id);

		if(!$user){
			return response(["message" => "The user with {$id} doesn't exist"], 404);
		}
		
		return response()->json(["data"=> $user],200);
    }
	
    public function store(Request $request){
		 try {		 		 
		$this->validate($request,[
			'email' => 'required|email|unique:users',
			'password'=>'required|between:6,12|confirmed',
			'password_confirmation'=>'required|between:6,12'
		]);
 		} catch (ValidationException $e) {
            return $e->getResponse();
        }
		$user = User::create($request->all());
		  

		$role = Role::find(User::UserRole());
		$user->roles()->attach($role);
		
		return response()->json(["message" => "The user with id {$user->id} has been created"],201);
	}

    public function update(Request $request, $id)
    {
        $user = User::find($id);

		if(!$user){
			return response(["message" => "The user with {$id} doesn't exist"], 404);
		}

		$this->validateRequest($request);
		$user->name 		= $request->get('name');
		$user->email 		= $request->get('email');
		$user->password 	= Hash::make($request->get('password'));

		$user->save();

		return response(["message" => "The user with with id {$user->id} has been updated"], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

		if(!$user){
			return response(["message" => "The user with {$id} doesn't exist"], 404);
		}

		$user->delete();

		return response(["message" => "The user with id {$id} has been deleted"], 200);
    }
	
	public function validateRequest(Request $request){

		$rules = [
			 
		];

		$this->validate($request, $rules);
	}
}
