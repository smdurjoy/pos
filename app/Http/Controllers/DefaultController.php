<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class DefaultController extends Controller
{
    function getCategories(Request $request) {
        $supplier_id = $request->supplier_id;
        $categories = Product::select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->with(['category'])->get();
        return response()->json($categories);
    }

    function getProducts(Request $request) {
        $category_id = $request->category_id;
        $products = Product::select('id', 'name')->where('category_id', $category_id)->get();
        return response()->json($products);
    }
}
