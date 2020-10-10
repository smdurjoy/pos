@extends('layouts.pdf-report')

@section('content')
    <h5 class="title">Daily Invoice Report ({{ $start_date }} to {{ $end_date }})</h5>
    <table width="100%" class="table table-bordered">
        <thead>
            <tr>
                <th>SL.</th>
                <th>Customer Name</th>
                <th>Invoice No</th>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
        @php
            $total_amount = '0';
        @endphp
        @foreach($data as $key => $details)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $details['payment']['customer']['name'] }}</td>
                <td>{{ $details['invoice_no'] }}</td>
                <td>{{ $details['date'] }}</td>
                <td>{{ $details['description'] }}</td>
                <td>{{ $details['payment']['total_amount'] }}</td>
            </tr>
            @php
                $total_amount += $details['payment']['total_amount'];
            @endphp
        @endforeach
            <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>
            <tr>
                <td colspan="5"><span style="font-weight: bold;">Total Amount</span></td>
                <td><span style="font-weight: bold;">{{ $total_amount }}</span></td>
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
