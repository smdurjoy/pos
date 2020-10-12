@extends('layouts.pdf-report')

@section('content')
    <h5 class="title"><u>Sales Invoice</u></h5>
    <table class="table table-bordered">
        <tr>
            <td><span style="font-weight: bold;">Customer:</span> {{ $payment['customer']['name'] }}</td>
            <td><span style="font-weight: bold;">Invoice No:</span> #{{ $invoice_no }}</td>
        </tr>
        <tr>
            <td><span style="font-weight: bold;">Mobile:</span> {{ $payment['customer']['number'] }}</td>
            <td><span style="font-weight: bold;">Date:</span> {{ date('d-m-Y', strtotime($date)) }} </td>
        </tr>
        <tr>
            <td><span style="font-weight: bold;">Address:</span> {{ $payment['customer']['address'] }}</td>
        </tr>
    </table>
    <table width="100%" class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Category</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
            @php
                $total_amount = '0';
            @endphp
            @foreach($invoice_details as $key => $details)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $details['category']['name'] }}</td>
                    <td>{{ $details['product']['name'] }}</td>
                    <td>{{ $details['selling_quantity'] }}</td>
                    <td class="text-right">{{ $details['unit_price'] }}</td>
                    <td class="text-right">{{ $details['selling_price'] }}</td>
                </tr>
                @php
                    $total_amount += $details['selling_price'];
                @endphp
            @endforeach

            <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>

            <tr>
                <td class="text-right" colspan="5"><span style="font-weight: bold">Total Amount: </span></td>
                <td class="text-right"><span style="font-weight: bold">{{ $total_amount }}</span></td>
            </tr>
            <tr>
                <td class="text-right" colspan="5">Less Discount: </td>
                <td class="text-right">{{ $payment['discount_amount'] }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="5">Paid Amount: </td>
                <td class="text-right">{{ $payment['paid_amount'] }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="5">Due Amount: </td>
                <td class="text-right">{{ $payment['due_amount'] }}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="5"><span style="font-weight: bold">Net Payable Amount: </span></td>
                <td class="text-right"><span style="font-weight: bold">{{ $payment['total_amount'] }}</span></td>
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
                    <td style="width: 40%;">
                        <p style="text-align: center; margin-left: 20px">Customer Signature</p>
                    </td>
                    <td style="width: 20%"></td>
                    <td style="width: 40%; text-align: right">
                        <p style="text-align: right">Seller Signature</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
