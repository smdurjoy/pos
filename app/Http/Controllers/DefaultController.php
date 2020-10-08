<?php

namespace App\Http\Controllers;

use App\Category;
use App\Invoice;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use App\Product;

class DefaultController extends Controller
{
    function getProductInfo() {
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['categories'] = Category::select('id', 'name')->get();
        $data['units'] = Unit::select('id', 'name')->get();
        // $data = json_decode(json_encode($data), true);
        // echo '<pre>'; print_r($data); die;
        return $data;
    }

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

    function getProductStock(Request $request) {
        $product_id = $request->product_id;
        $stock = Product::where('id', $product_id)->first()->quantity;
        return $stock;
    }

    function getInvoiceNoAndCurrentDate(Request $request) {
        $invoice_data = Invoice::orderBy('id', 'desc')->first();

        if($invoice_data == null) {
            $firstInvoiceNo = 100100;
            $data['invoiceNo'] = $firstInvoiceNo+1;
        } else {
            $invoice_no = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $data['invoiceNo'] = $invoice_no+1;
        }

        $data['date'] = date('Y-m-d');

        return response()->json($data);
    }
}
