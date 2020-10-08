<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    function payment() {
        return $this->belongsTo('App\Payment', 'id', 'invoice_id')->with('customer');
    }
}

