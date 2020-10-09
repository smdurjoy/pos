@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/stocks')}} ">Stock Report</a></li>
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
                                <h3 class="card-title">Stock Report</h3>
                                <a href="{{ url('/print/stock') }}" class="btn btn-dark btn-sm" style="float: right" target="_blank"><i class="fa fa-download"></i> Download PDF</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="stocksTable" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">SL.</th>
                                            <th class="text-bold">Supplier Name</th>
                                            <th class="text-bold">Category</th>
                                            <th class="text-bold">Product Name</th>
                                            <th class="text-bold">Stock</th>
                                            <th class="text-bold">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchaseTableBody">
                                        @foreach($stocks as $key => $stock)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $stock['supplier']['name'] }}</td>
                                                <td>{{ $stock['category']['name'] }}</td>
                                                <td>{{ $stock['name'] }}</td>
                                                <td>{{ $stock['quantity'] }}</td>
                                                <td>{{ $stock['unit']['name'] }}</td>
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
    <script type="text/javascript">
        $("#stocksTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": false,
        });
    </script>
@endsection
