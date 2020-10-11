@extends('layouts.pdf-report')

@section('content')
    <h5 class="title">Customer Invoice Details</h5>
    <table width="100%" class="table table-bordered">
        <tbody>
        <tr>
            <td><span style="font-weight: bold">Customer: </span> {{ $payment['customer']['name'] }}</td>
            <td><span style="font-weight: bold">Invoice No:</span> #{{ $invoice_no }}</td>
        </tr>
        <tr>
            <td><span style="font-weight: bold">Mobile: </span>{{ $payment['customer']['number'] }}</td>
            <td><span style="font-weight: bold">Date: </span> {{ date('d-m-Y', strtotime($date)) }}</td>
        </tr>
        <tr>
            <td><span style="font-weight: bold">Address: </span>{{ $payment['customer']['address'] }}</td>
        </tr>
        </tbody>
    </table>
    <table width="100%" class="table table-bordered">
        <thead>
        <tr>
            <th>SL.</th>
            <th>Category</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Unit Price</th>
            <th>Amount</th>
        </tr>
        </thead>

        <tbody>
        @php
            $total_amount = 0;
        @endphp
        @foreach($invoice_details as $key => $details)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $details['category']['name'] }}</td>
                <td>{{ $details['product']['name'] }}</td>
                <td>{{ $details['selling_quantity'] }}</td>
                <td>{{ $details['unit_price'] }}</td>
                <td>{{ $details['selling_price'] }}</td>
            </tr>
            @php
              $total_amount += $details['selling_price'];
            @endphp
        @endforeach
        <tr><td colspan="5"></td></tr><tr><td colspan="5"></td></tr>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Total Amount: </td>
            <td><span style="font-weight: bold;"> {{ $total_amount }} Tk</span></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Discount Amount: </td>
            <td>{{ $payment['discount_amount'] }} Tk</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Paid Amount: </td>
            <td style="font-weight: bold;">{{ $payment['paid_amount'] }} Tk</td>
        </tr>
        </tbody>
    </table>
@endsection

@section('bottom-content')
    <div class="row" style="margin-top: 2.5rem">
        <div class="col-md-12">
            <hr style="margin-bottom: 0">
            <table style="width: 100%; border:0;">
                <tr>
                    <td style="width: 40%; text-align: right">
                        <p style="text-align: right">Owner Signature</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
