<?php

namespace Harii\User\Cart;


use Illuminate\Http\Request;
use Harii\User\Cart\Cart;
use Harii\Admin\Product\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use DB;

class CartController extends Controller
{
	public function __construct()
    {
		 
    }
	
	public function postCart(Request $request)
	{
		$this->user = JWTAuth::parseToken()->toUser();
		try{
 		$this->validate($request,[
			'product_id' => 'integer|required|exists:products,id',
			'qty' => 'integer|required'
		]);
		} catch (ValidationException $e) {
            return $e->getResponse();
        }
		  
		$product= Product::find($request->get('product_id'));
		$request->request->add(['user_id'=>$this->user->id, 'price'=> $product->price]);
		
		if($request->qty == 0){
			$cart = Cart::where(['user_id'=> $this->user->id,'product_id'=>$product->id])->delete();
		}
		else
		{
			$cart = Cart::updateOrCreate(
				['user_id'=>$this->user->id, 'product_id'=> $product->id], ['qty' => $request->qty]
			);
		}
		return response()->json(["message" => "Product added to cart"],201);
	}
	
	public function getCart(Request $request)
	{
		$this->user = JWTAuth::parseToken()->toUser(); 
 		$cart = Cart::where('user_id', $this->user->id)->get();
		
		
		return response()->json(["data" => $cart],200);
	}
	
	
    
}
