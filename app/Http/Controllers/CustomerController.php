<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Customer;
use Auth;

class CustomerController extends Controller
{
    function index() {
        Session::put('page', 'customers');
        return view('customers');
    }

    function getCustomers() {
        $data = Customer::orderBy('id', 'desc')->get();
        return $data;
    }

    function deleteCustomer($id) {
        $result = Customer::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }
}
