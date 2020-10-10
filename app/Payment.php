<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    function customer() {
        return $this->belongsTo('App\Customer', 'customer_id', 'id')->select('id', 'name', 'number', 'address');
    }

    function invoice() {
        return $this->belongsTo('App\Invoice');
    }
}
