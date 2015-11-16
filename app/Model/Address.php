<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;
    protected $fillable=[
        'address',
        'address2',
        'city',
        'zone_id',
        'country_id',
        'postcode'
       ];
}
