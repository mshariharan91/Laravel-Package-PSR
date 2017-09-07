<?php

namespace Harii\Admin\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
		'description',
		'price',
    ];
	
}
