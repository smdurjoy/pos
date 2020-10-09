<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    function payment() {
        return $this->belongsTo('App\Payment', 'id', 'invoice_id')->with('customer');
    }

    function invoiceDetails() {
        return $this->hasMany('App\InvoiceDetail', 'invoice_id', 'id')->with('category', 'product');
    }
}

