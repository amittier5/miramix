<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IngredientFormfactor extends Model
{
	protected $fillable = array('ingredient_id', 'form_factor_id');
   
    public $timestamps = false;
}
