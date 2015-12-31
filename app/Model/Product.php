<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;
    // protected $fillable=[
    //     'name',
    //     'price',
    //     'maximum_weight',
    //     'minimum_weight'
    //    ];

    protected $guarded = array();  // Important

    protected $table = 'products';

    public function AllProductFormfactors()
    {
        return $this->hasMany('App\Model\ProductFormfactor');
    }

    public function GetBrandDetails()
    {
        return $this->belongsTo('App\Model\Brandmember','brandmember_id');
    }


}
