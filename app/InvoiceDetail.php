<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    function category() {
        return $this->belongsTo('App\Category')->select('id', 'name');
    }

    function product() {
        return $this->belongsTo('App\Product')->select('id', 'name', 'quantity');
    }
}
