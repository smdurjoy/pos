<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Purchase;
use App\Supplier;
use App\Category;
use App\Unit;
use Auth;

class PurchaseController extends Controller
{
    function index() {
        Session::put('page', 'purchase');
        return view('purchase');
    }

    function getPurchases() {
        $data = Purchase::orderBy('date', 'desc')->with('product', 'supplier', 'category')->get();
        return $data;
    }

    function deletePurchase($id) {
        $result = Purchase::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function addPurchase(Request $request) {
        if($request->category_id == null) {
            return 0;
        } else {
            $count_category = count($request->category_id);
            for($i = 0; $i < $count_category; $i++) {
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];
                $purchase->purchase_number = $request->purchase_no[$i];
                $purchase->description = $request->description[$i];
                $purchase->buying_quantity = $request->buying_qt[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->status = '0';
                $purchase->created_by = Auth::user()->id;
                $purchase->save();
            }
        }

        return 1;
    }

    function getPurchaseDetails($id) {
        $data['Purchase'] =  Purchase::find($id);
        $data['suppliers'] = Supplier::select('id', 'name')->get();
        $data['categories'] = Category::select('id', 'name')->get();
        $data['units'] = Unit::select('id', 'name')->get();

        return $data;
    }

    function updatePurchaseDetails(Request $request) {
        $id = $request->id;
        $supplier = $request->supplier;
        $category = $request->category;
        $unit = $request->unit;
        $name = $request->name;
        $updated_by = Auth::user()->id;

        $result = Purchase::where('id', $id)->update([
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
