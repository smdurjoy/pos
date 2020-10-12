@extends('layouts.app')
@section('title', 'Daily Invoice Report')

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
                            <li class="breadcrumb-item active"><a href=" {{url('/daily-invoice')}} ">Daily Invoice</a></li>
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
                                <h3 class="card-title">Daily Invoice Report</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="dailyInvoiceForm" method="get" action="{{ url('/print/dailyInvoice') }}" target="_blank">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">Start Date</label>
                                                <div class="input-group date" id="startDate" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#startDate" placeholder="DD-MM-YYYY" id="date" name="start_date"/>
                                                    <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">End Date</label>
                                                <div class="input-group date" id="endDate" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#endDate" placeholder="DD-MM-YYYY" id="date" name="end_date"/>
                                                    <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-dark btn-sm" type="submit">Generate PDF</button>
                                    </div>
                                </form>
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
        // Date picker format
        $('#startDate, #endDate').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        // Category and edit validation rules and messages
        const validationRules = Object.assign({
            start_date: {
                required: true,
            },
            end_date: {
                required: true,
            },
        });

        const validationMsg = Object.assign({
            start_date: {
                required: "Please select start date",
            },
            end_date: {
                required: "Please select end date",
            },
        });

        validation('#dailyInvoiceForm', validationRules, validationMsg)
    </script>
@endsection
