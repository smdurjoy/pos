<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Supplier;
use App\Category;
use App\Unit;
use Auth;

class ProductController extends Controller
{
    function index() {
        Session::put('page', 'products');
        return view('products');
    }

    function getProducts() {
        $data = Product::orderBy('id', 'desc')->with('supplier', 'category', 'unit')->get();
        return $data;
    }

    function getProductInfo() {
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['categories'] = Category::select('id', 'name')->get();
        $data['units'] = Unit::select('id', 'name')->get();
        // $data = json_decode(json_encode($data), true);
        // echo '<pre>'; print_r($data); die;
        return $data;
    }

    function deleteProduct($id) {
        $result = Product::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function addProduct(Request $request) {
        $supplier = $request->supplier;
        $category = $request->category;
        $unit = $request->unit;
        $name = $request->name;
        $created_by = Auth::user()->id;

        $result = Product::insert([
            'supplier_id' => $supplier,
            'category_id' => $category,
            'unit_id' => $unit,
            'name' => $name,
            'created_by' => $created_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function getProductDetails($id) {
        $data['product'] =  Product::find($id);
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['categories'] = Category::select('id', 'name')->get();
        $data['units'] = Unit::select('id', 'name')->get();

        return $data;
    }

    function updateProductDetails(Request $request) {
        $id = $request->id;
        $supplier = $request->supplier;
        $category = $request->category;
        $unit = $request->unit;
        $name = $request->name;
        $updated_by = Auth::user()->id;

        $result = Product::where('id', $id)->update([
            'supplier_id' => $supplier,
            'category_id' => $category,
            'unit_id' => $unit,
            'name' => $name,
            'updated_by' => $updated_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }
}
