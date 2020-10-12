@extends('layouts.pdf-report')

@section('content')
    <h5 class="title">Customer Payment Summary</h5>
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
            <th>Date</th>
            <th class="text-right">Amount</th>
        </tr>
        </thead>

        <tbody>
            @foreach($payment_details as $key => $summary)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ date('d-m-Y', strtotime($summary['date'])) }}</td>
                    <td class="text-right">{{ $summary['current_paid_amount'] }} Tk</td>
                </tr>
            @endforeach
        <tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">Total Paid Amount: </td>
            <td class="text-right"><span style="font-weight: bold;"> {{ $payment['paid_amount'] }} Tk</span></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">Due Amount: </td>
            <td class="text-right">{{ $payment['due_amount'] }} Tk</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">Net Payble Amount: </td>
            <td class="text-right" style="font-weight: bold;">{{ $payment['total_amount'] }} Tk</td>
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
                        <p style="text-align: right">Owner Signature</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
