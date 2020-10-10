<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\Invoice;
use App\InvoiceDetail;
use App\Payment;
use App\PaymentDetail;
use Auth;
use PDF;

class InvoiceController extends Controller
{
    function index() {
        Session::put('page', 'invoice');
        return view('invoice');
    }

    function getInvoices() {
        return Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->with('payment')->get();
    }

    function addInvoice(Request $request) {
        if($request->category_id == null) {
            return 0;
        }
        else if($request->paid_amount > $request->estimated_amount) {
            return 2;
        }
        else {
            $invoice = new Invoice();
            $invoice->invoice_no = $request->invoice_no;
            $invoice->date = date('Y-m-d', strtotime($request->date));
            $invoice->description = $request->description;
            $invoice->status = 0;
            $invoice->created_by = Auth::user()->id;
            $invoice->save();

            DB::transaction(function() use($request, $invoice){
                if($invoice->save()) {
                    $count_category = count($request->category_id);
                    for ($i = 0; $i < $count_category; $i++) {
                        $invoice_details = new InvoiceDetail();
                        $invoice_details->date = $request->date;
                        $invoice_details->invoice_id = $invoice->id;
                        $invoice_details->category_id = $request->category_id[$i];
                        $invoice_details->product_id = $request->product_id[$i];
                        $invoice_details->selling_quantity = $request->selling_qty[$i];
                        $invoice_details->unit_price = $request->unit_price[$i];
                        $invoice_details->selling_price = $request->selling_price[$i];
                        $invoice_details->status = 0;
                        $invoice_details->save();
                    }

                    if($request->customer == '0') {
                        $customer = new Customer();
                        $customer->name = $request->customer_name;
                        $customer->number = $request->customer_number;
                        $customer->address = $request->customer_address;
                        $customer->save();
                        $customer_id = $customer->id;
                    } else {
                        $customer_id = $request->customer;
                    }

                    $payment = new Payment();
                    $payment_details = new PaymentDetail();
                    $payment->invoice_id = $invoice->id;
                    $payment->customer_id = $customer_id;
                    $payment->paid_status = $request->paid_status;
                    $payment->total_amount = $request->estimated_amount;
                    $payment->discount_amount = $request->discount_amount;

                    if($request->paid_status == 'full_paid') {
                        $payment->paid_amount = $request->estimated_amount;
                        $payment->due_amount = '0';
                        $payment_details->current_paid_amount = $request->estimated_amount;
                    } else if($request->paid_status == 'full_due') {
                        $payment->paid_amount = '0';
                        $payment->due_amount = $request->estimated_amount;
                        $payment_details->current_paid_amount = '0';
                    } else if($request->paid_status == 'partial_paid') {
                        $payment->paid_amount = $request->paid_amount;
                        $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                        $payment_details->current_paid_amount = $request->paid_amount;
                    }

                    $payment->save();
                    $payment_details->invoice_id = $invoice->id;
                    $payment_details->date = date('Y-m-d', strtotime($request->date));
                    $payment_details->save();
                }
            });

            return 1;
        }
    }

    function pendingInvoice() {
        Session::put('page', 'pendingInvoice');
        return view('pendingInvoice');
    }

    function pendingInvoiceList() {
        return Invoice::where('status', 0)->with('payment')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
    }

    function deleteInvoice($id) {
        $invoice = Invoice::find($id);
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        return 1;
    }

    function getApproveInvoiceDetails($id) {
        return Invoice::with('payment', 'invoiceDetails')->find($id);
    }

    function approveInvoice(Request $request) {
        foreach ($request->selling_qty as $key => $value) {
            $invoice_details = InvoiceDetail::where('id', $key)->first();
            $productQuantity = Product::where('id', $invoice_details->product_id)->first()->quantity;
            if($productQuantity < $request->selling_qty[$key]) {
                return 2;
            }
        }
        $invoice = Invoice::find($request->id);
        $invoice->approved_by = Auth::user()->id;
        $invoice->status = '1';
        DB::transaction(function () use($request, $invoice) {
            foreach ($request->selling_qty as $key => $value) {
                $invoice_details = InvoiceDetail::where('id', $key)->first();
                $invoice_details->status = 1;
                $invoice_details->save();
                $product = Product::where('id', $invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
                $product->save();
            }
            $invoice->save();
        });
        return 1;
    }

    function printInvoicePage() {
        Session::put('page', 'printInvoice');
        $invoices = Invoice::where('status', 1)->with('payment')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('printInvoice')->with(compact('invoices'));
    }

    function printInvoiceList() {
        return Invoice::where('status', 1)->with('payment')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
    }

    function printInvoice($id) {
        $data = Invoice::with('invoiceDetails', 'payment')->find($id);
        $pdf = PDF::loadView('pdf.invoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    function dailyInvoice() {
        return view('dailyInvoice');
    }

    function dailyInvoicePdf(Request $request) {
        $startDate = $request->start_date;
        $endtDate = $request->end_date;
        $data['data'] = Invoice::whereBetween('date', [$startDate, $endtDate])->where('status', 1)->with('payment')->get();
        $data['start_date'] = date('d-m-Y', strtotime($request->start_date));
        $data['end_date'] = date('d-m-Y', strtotime($request->end_date));
        $pdf = PDF::loadView('pdf.daily-invoice-report', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
