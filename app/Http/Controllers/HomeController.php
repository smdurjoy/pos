<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\InvoiceDetail;
use App\Product;
use App\Purchase;
use App\Supplier;
use App\Visitor;
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
        $userIP = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set("Asia/Dhaka");
        $visitTimeDate = date("Y-m-d h:i:sa");
        $informations = \Location::get($userIP);

        if($informations != false) {
            Visitor::insert([
                'ipAddress'=> $userIP,
                'visitTime' => $visitTimeDate,
                'countryName' => $informations->countryName,
                'regionName' => $informations->regionName,
                'cityName' => $informations->cityName,
                'zipCode' => $informations->zipCode,
            ]);
        }

        $customers = Customer::count();
        $suppliers = Supplier::count();
        $categories = Category::count();
        $products = Product::count();

        $todayDate = date('Y-m-d');
        $totalMonthInvoice = InvoiceDetail::where('status', 1)->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('selling_price');
        $totalMonthPurchase = Purchase::where('status', 1)->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('buying_price');

        $todaySale = InvoiceDetail::where('date', $todayDate)->where('status', 1)->sum('selling_price');
        $todayPurchase = Purchase::where('date', $todayDate)->where('status', 1)->sum('buying_price');
        return view('index')->with(compact('customers', 'suppliers', 'categories', 'products', 'todaySale', 'todayPurchase', 'totalMonthInvoice', 'totalMonthPurchase'));
    }

    function visitors() {
        return view('visitors');
    }

    function getVisitors() {
        return Visitor::all();
    }

    function deleteVisitor($id) {
        $result = Visitor::find($id)->delete();
        if($result == true) {
            return 1;
        } else {
            return 0;
        }
    }
}
