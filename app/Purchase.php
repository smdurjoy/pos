<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    function supplier() {
        return $this->belongsTo('App\Supplier')->select('id', 'name');
    }

    function category() {
        return $this->belongsTo('App\Category')->select('id', 'name');
    }

    function product() {
        return $this->belongsTo('App\Product')->select('id', 'name', 'unit_id')->with('unit');
    }
}
