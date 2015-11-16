<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	public $timestamps = false;
    

    protected $guarded = array();  // Important

    protected $table = 'subscription_history';

   
}