<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class StockController extends Controller
{
    function stockReport() {
        Session::put('page', 'stockReport');
        $stocks = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->with('supplier', 'category', 'unit')->get();
        return view('stocks', compact('stocks'));
    }

    function printStock() {
        $data['stocks'] = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->with('supplier', 'category', 'unit')->get();
        $pdf = PDF::loadView('pdf.stock-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    function supplierOrProductWise() {
        Session::put('page', 'stockReportProductOrSupplierWise');
        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();
        return view('supplierOrProductWiseStock', $data);
    }

    function supplierWisePdf(Request $request) {
        $data['suppliers'] = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->with('supplier', 'category', 'unit')->where('supplier_id', $request->supplier_id)->get();
        $pdf = PDF::loadView('pdf.supplier-wise-stock-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    function productWisePdf(Request $request) {
        $data['product'] = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->with('supplier', 'category', 'unit')->where('id', $request->product_id)->first();
        $pdf = PDF::loadView('pdf.product-wise-stock-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
