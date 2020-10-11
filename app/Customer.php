<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    function payments() {
        return $this->hasMany('App\Payment')->select('id', 'customer_id');
    }
}
