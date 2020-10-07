<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Invoice;
use App\InvoiceDetail;
use App\Payment;
use App\PaymentDetail;

class InvoiceController extends Controller
{
    function index() {
        Session::put('page', 'invoice');
        return view('invoice');
    }

    function getInvoices() {
        return Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->with('product', 'supplier', 'category')->get();
    }
}
