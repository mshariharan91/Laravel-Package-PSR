<?php

namespace Harii\User\Cart;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
	
	protected $fillable = ['product_id', 'user_id', 'price','qty'];
	
}
