<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
	protected $fillable = array('name', 'description', 'chemical_name','price_per_gram','list_manufacture','type','organic','antibiotic_free','gmo');
   
    public $timestamps = false;

    public function ingredientFormFactor()
    {
        return $this->hasMany('App\IngredientFormfactor');
    }
}
