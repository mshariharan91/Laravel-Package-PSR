<?php

namespace Harii\User;

use Harii\Auth\User;
use Harii\Admin\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	public function __construct()
    {
    }
	
	public function getProductList()
	{
		$products =  Product::all();
		return response()->json(["data" => $products],200);
	}
    
}
