<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Customer;
use Auth;
use PDF;

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

    function addCustomer(Request $request) {
        $name = $request->name;
        $number = $request->number;
        $email = $request->email;
        $address = $request->address;
        $created_by = Auth::user()->id;

        $result = Customer::insert([
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

    function getCustomerDetails($id) {
        return Customer::find($id);
    }

    function updateCustomerDetails(Request $request) {
        $id = $request->id;
        $name = $request->name;
        $number = $request->number;
        $address = $request->address;
        $email = $request->email;
        $updated_by = Auth::user()->id;

        $result = Customer::where('id', $id)->update([
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

    function creditCustomers() {
        Session::put('page', 'creditCustomers');
        return view('creditCustomers');
    }

    function getCreditCustomers() {
        return Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->with('invoice', 'customer')->get();
    }

    function creditCustomersPdf() {
        $data['data'] = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->with('invoice', 'customer')->get();
        $pdf = PDF::loadView('pdf.credit-customers-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
