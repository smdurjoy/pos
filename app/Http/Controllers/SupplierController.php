<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Supplier;

class SupplierController extends Controller
{
    function index() {
        Session::put('page', 'suppliers');
        return view('suppliers');
    }

    function getSuppliers() {
        $data = Supplier::orderBy('id', 'desc')->get();
        return $data;
    }

    function deleteSupplier($id) {
        $result = Supplier::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function addSupplier(Request $request) {
        $name = $request->input('name');
        $number = $request->input('number');
        $email = $request->input('email');
        $address = $request->input('address');

        $result = Supplier::insert([
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'address' => $address,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }
}
