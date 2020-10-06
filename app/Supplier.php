<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    function products() {
        return $this->hasMany('App\Product')->select('id', 'supplier_id');
    }
}
