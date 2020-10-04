<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Purchase;
use App\Supplier;
use App\Category;
use App\Product;
use App\Unit;
use Auth;

class PurchaseController extends Controller
{
    function index() {
        Session::put('page', 'purchase');
        return view('purchase');
    }

    function getPurchases() {
        $data = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->with('product', 'supplier', 'category')->get();
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

    function pendingPurchase() {
        Session::put('page', 'pendingPurchase');
        return view('pendingPurchase');
    }

    function pendingPurchaseList() {
        $data = Purchase::where('status', 0)->with('product', 'supplier', 'category')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return $data;
    }

    function updatePurchaseStatus(Request $request) {
        $id = $request->id;
        $purchase = Purchase::find($id);
        $product = Product::where('id', $purchase->product_id)->first();
        $purchase_qty = ((float) ($purchase->buying_quantity))+((float) ($product->quantity));
        $product->quantity = $purchase_qty;
        $updateProductQuantity = $product->save();

        if($updateProductQuantity == true) {
            Purchase::where('id', $id)->update(['status' => 1]);
        }
    }
}
