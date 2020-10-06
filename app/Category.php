<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function products() {
        return $this->hasMany('App\Product')->select('id', 'category_id');
    }
}
