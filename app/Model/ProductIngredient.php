<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
	public $timestamps = false;
    protected $guarded = array();  // Important

    protected $table = 'product_ingredients';

    public function ingredientProducts()
    {
        return $this->belongsTo('App\Model\Product','product_id');
    }
    public function fProducts()
    {
        return $this->belongsTo('App\Model\ProductFormfactor','product_id');
    }
   
}
