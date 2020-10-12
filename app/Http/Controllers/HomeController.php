<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Invoice;
use App\InvoiceDetail;
use App\Product;
use App\Purchase;
use App\Supplier;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Session::put('page', 'home');
        $customers = Customer::count();
        $suppliers = Supplier::count();
        $categories = Category::count();
        $products = Product::count();

        $todayDate = date('Y-m-d');
        $totalMonthInvoice = InvoiceDetail::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('selling_price');
        $totalMonthPurchase = Purchase::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('buying_price');

        $todaySale = InvoiceDetail::where('date', $todayDate)->sum('selling_price');
        $todayPurchase = Purchase::where('date', $todayDate)->sum('buying_price');
        return view('index')->with(compact('customers', 'suppliers', 'categories', 'products', 'todaySale', 'todayPurchase', 'totalMonthInvoice', 'totalMonthPurchase'));
    }
}
