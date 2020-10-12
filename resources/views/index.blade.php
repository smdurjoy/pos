@extends('layouts.app')
@section('title', 'Amar Store | Dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/admin/banners')}} ">Banners</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $suppliers }}</h3>
                                <p>Suppliers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fas fa-boxes"></i>
                            </div>
                            <a href="{{ url('suppliers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $customers }}</h3>
                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <a href="{{ url('customers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                      <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $categories }}</h3>
                                <p>Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fas fas fa-layer-group"></i>
                            </div>
                            <a href="{{ url('categories') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $products }}</h3>
                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="fab fa-palfed"></i>
                            </div>
                            <a href="{{ url('products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-4">
                        <div class="callout callout-info" style="background: #1a3f5a; color: white; border-right: 5px solid #117A8B">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th class="text-bold"><h5 style="font-weight: bold; font-size: 18px"><u>Today's Report</u></h5></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="text-bold">Total Sales</td>
                                    <td class="text-bold">{{ $todaySale }} Tk</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Total Purchase</td>
                                    <td class="text-bold">{{ $todayPurchase }} Tk</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="callout callout-success" style="background: #314631; color: white; border-right: 5px solid #1E7E34">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th class="text-bold"><h5 style="font-weight: bold; font-size: 18px"><u>This Month</u></h5></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="text-bold">Total Sales</td>
                                    <td class="text-bold">{{ $totalMonthInvoice }} Tk</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Total Purchase</td>
                                    <td class="text-bold">{{ $totalMonthPurchase }} Tk</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
