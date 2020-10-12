@extends('layouts.pdf-report')

@section('content')
    <h5 class="title">Daily Invoice Report ({{ $start_date }} to {{ $end_date }})</h5>
    <table width="100%" class="table table-bordered text-center">
        <thead>
            <tr>
                <th class="text-center">SL.</th>
                <th class="text-center">Purchase No</th>
                <th class="text-center">Date</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center">Amount</th>
            </tr>
        </thead>

        <tbody>
            @php
                $total_amount = '0';
            @endphp
            @foreach($data as $key => $details)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $details['purchase_number'] }}</td>
                    <td>{{ date('d-m-Y', strtotime($details['date'])) }}</td>
                    <td>{{ $details['product']['name'] }}</td>
                    <td>{{ $details['buying_quantity'] }} {{ $details['product']['unit']['name'] }}</td>
                    <td>{{ $details['unit_price'] }} Tk</td>
                    <td>{{ $details['buying_price'] }} Tk</td>
                </tr>
                @php
                    $total_amount += $details['buying_price'];
                @endphp
            @endforeach
            <tr><td colspan="7"></td></tr><tr><td colspan="6"></td></tr>
            <tr>
                <td colspan="6" style="text-align: right"><span style="font-weight: bold;">Total Amount: </span></td>
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
