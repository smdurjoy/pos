@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/print-invoice')}} ">Print Invoice</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Print Invoices</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="printInvoiceTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Customer Info</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="invoiceTableBody">
                                        @foreach($invoices as $key => $invoice)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $invoice['payment']['customer']['name'] }}</td>
                                                <td>{{ $invoice['invoice_no'] }}</td>
                                                <td>{{ $invoice['date'] }}</td>
                                                <td>{{ $invoice['description'] }}</td>
                                                <td>{{ $invoice['payment']['total_amount'] }}</td>
                                                <td>
                                                    <a href='{{url('print/invoice/'.$invoice['id'])}}' title='Print Invoice' class='btn btn-info btn-sm actionBtn' target="_blank"> <i class='fas fa-print deleteButton'></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <!-- /.card-body -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
        $("#printInvoiceTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": false,
        });
    </script>
@endsection
