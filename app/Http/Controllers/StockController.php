<?php

namespace App\Http\Controllers;

use App\Product;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class StockController extends Controller
{
    function stockReport() {
        Session::put('page', 'stocks');
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
        $data['suppliers'] = Supplier::all();
        return view('supplierOrProductWiseStock', $data);
    }

    function supplierOrProductWisePdf(Request $request) {
        if($request->product_name == '') {
            $data['suppliers'] = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->with('supplier', 'category', 'unit')->where('supplier_id', $request->supplier_id)->get();
            $pdf = PDF::loadView('pdf.supplier-wise-stock-pdf', $data);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            return $pdf->stream('document.pdf');
        } else {

        }
    }
}
