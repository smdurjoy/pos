@extends('layouts.pdf-report')

@section('content')
    <h5 class="title">Stock Report</h5>
    <strong>Supplier Name: </strong> {{ $suppliers[0]['supplier']['name'] }}
    <table width="100%" class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>In.Qty</th>
                <th>Out.Qty</th>
                <th>Unit</th>
            </tr>
        </thead>

        <tbody>
        @foreach($suppliers as $key => $supplier)
            @php
                $total_buy = App\Purchase::where('category_id', $supplier->category_id)->where('product_id', $supplier->id)->where('status', 1)->sum('buying_quantity');
                $total_sell = App\InvoiceDetail::where('category_id', $supplier->category_id)->where('product_id', $supplier->id)->where('status', 1)->sum('selling_quantity');
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $supplier['category']['name'] }}</td>
                <td>{{ $supplier['name'] }}</td>
                <td>{{ $total_buy  }}</td>
                <td>{{ $total_sell }}</td>
                <td>{{ $supplier['quantity'] }}</td>
                <td>{{ $supplier['unit']['name'] }}</td>
            </tr>
        @endforeach
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

