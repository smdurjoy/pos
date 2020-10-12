@extends('layouts.pdf-report')
@section('title', 'Credit Customers Report')

@section('content')
    <h5 class="title">Credit Customers Report</h5>
    <table width="100%" class="table table-bordered">
        <thead>
        <tr>
            <th>SL.</th>
            <th>Customer Info</th>
            <th>Invoice No</th>
            <th>Date</th>
            <th>Due Amount</th>
        </tr>
        </thead>

        <tbody>
        @php
            $total_amount = '0';
        @endphp
        @foreach($data as $key => $details)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $details['customer']['name'] }} ({{ $details['customer']['number'] }}, {{ $details['customer']['address'] }})</td>
                <td>#{{ $details['invoice']['invoice_no'] }}</td>
                <td>{{ $details['invoice']['date'] }}</td>
                <td>{{ $details['due_amount'] }} Tk</td>
            </tr>
            @php
                $total_amount += $details['due_amount'];
            @endphp
        @endforeach
        <tr><td colspan="5"></td></tr><tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="4" style="text-align: right"><span style="font-weight: bold;">Total Due Amount: </span></td>
            <td><span style="font-weight: bold;">{{ $total_amount }} Tk</span></td>
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
                    <td style="width: 20%"></td>
                    <td style="width: 40%; text-align: right">
                        <p style="text-align: right">Owner Signature</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
