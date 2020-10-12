@extends('layouts.pdf-report')
@section('title', 'Stock Report')

@section('content')
    <h5 class="title">Stock Report</h5>
    <table width="100%" class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Supplier Name</th>
                <th>Category</th>
                <th>Product Name</th>
                <th class="text-bold">In.Qty</th>
                <th class="text-bold">Out.Qty</th>
                <th>Stock</th>
                <th>Unit</th>
            </tr>
        </thead>

        <tbody>
            @foreach($stocks as $key => $product)
                @php
                    $total_buy = App\Purchase::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', 1)->sum('buying_quantity');
                    $total_sell = App\InvoiceDetail::where('category_id', $product->category_id)->where('product_id', $product->id)->where('status', 1)->sum('selling_quantity');
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product['supplier']['name'] }}</td>
                    <td>{{ $product['category']['name'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $total_buy  }}</td>
                    <td>{{ $total_sell }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['unit']['name'] }}</td>
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
