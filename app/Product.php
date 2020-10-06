<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    function supplier() {
        return $this->belongsTo('App\Supplier')->select('id', 'name');
    }

    function category() {
        return $this->belongsTo('App\Category')->select('id', 'name');
    }

    function unit() {
        return $this->belongsTo('App\Unit')->select('id', 'name');
    }

    function purchase() {
        return $this->hasMany('App\Purchase')->select('id', 'product_id');
    }
}
