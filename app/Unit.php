<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    function products() {
        return $this->hasMany('App\Product')->select('id', 'unit_id');
    }
}
