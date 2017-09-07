<?php

namespace Harii\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Harii\Admin\Product\Product;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products =  Product::all();
		return response()->json(["data" => $products],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try {
        $this->validate($request,[
			'name' => 'required'
		]);
		} catch (ValidationException $e) {
            return $e->getResponse();
        }
 
		$product = Product::create($request->all());
		
		return response()->json(["message" => "The product with id {$product->id} has been created"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

		if(!$product){
			return response(["message" => "The product with {$id} doesn't exist"], 404);
		}
		
		return response()->json(["data"=> $product],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $product = Product::find($id);

		if(!$product){
			return response(["message" => "The product with {$id} doesn't exist"], 404);
		}

		$this->validateRequest($request);
		$product->name 		= $request->get('name');
		$product->description = $request->get('description');
		$product->price 	= $request->get('price');

		$product->save();

		return response(["message" => "The product with with id {$product->id} has been updated"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

		if(!$product){
			return response(["message" => "The product with {$id} doesn't exist"], 404);
		}

		$product->delete();

		return response(["message" => "The product with id {$id} has been deleted"], 200);
    }
	
	public function validateRequest(Request $request){

		$rules = [
			 
		];

		$this->validate($request, $rules);
	}
}
