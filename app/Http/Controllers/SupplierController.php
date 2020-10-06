<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Supplier;
use App\Product;
use Auth;

class SupplierController extends Controller
{
    function index() {
        Session::put('page', 'suppliers');
        return view('suppliers');
    }

    function getSuppliers() {
        $data = Supplier::orderBy('id', 'desc')->with('products')->get();
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
        $created_by = Auth::user()->id;

        $result = Supplier::insert([
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'address' => $address,
            'created_by' => $created_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function getSupplierDetails($id) {
        return Supplier::find($id);
    }

    function updateSupplierDetails(Request $request) {
        $id = $request->id;
        $name = $request->name;
        $number = $request->number;
        $address = $request->address;
        $email = $request->email;
        $updated_by = Auth::user()->id;

        $result = Supplier::where('id', $id)->update([
            'name' => $name,
            'number' => $number,
            'address' => $address,
            'email' => $email,
            'updated_by' => $updated_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }
}
