<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FormFactor extends Model
{
	public $timestamps = false;
    protected $fillable=[
        'name',
        'price',
        'maximum_weight',
        'minimum_weight'
       ];
}
