<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payment;
use App\PaymentDetail;
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

    function getEditInvoiceDetails(Request $request) {
        return Invoice::where('id', $request->id)->with('invoiceDetails', 'payment')->get();
    }

    function updateCustomerInvoice(Request $request) {
        if($request->due_amount < $request->paid_amount) {
            return 2;
        } else {
            $payment = Payment::where('invoice_id', $request->invoice_id)->first();
            $payment_details = new PaymentDetail();
            if($request->paid_status == 'full_paid') {
                $payment->paid_amount = Payment::where('invoice_id', $request->invoice_id)->first()['paid_amount']+$request->due_amount;
                $payment->due_amount = 0;
                $payment_details->current_paid_amount = $request->deu_amount;
                $payment->paid_status = 'full_paid';
            } else if($request->paid_status == 'partial_paid') {
                $payment->paid_amount = $payment['paid_amount']+$request->paid_amount;
                $payment->due_amount = $payment['due_amount']-$request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }
            $payment->save();
            $payment_details->invoice_id = $request->invoice_id;
            $payment_details->date = $request->date;
            $payment_details->save();

            return 1;
        }
    }
}
