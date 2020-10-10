@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/customers')}} ">Customers</a></li>
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
                                <h3 class="card-title">Credit Customers</h3>
                                <a target="_blank" href="{{ url('print/credit-customers') }}" class="btn btn-dark btn-sm" style="float: right"><i class="fa fa-print"></i> Generate PDF</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="creditCustomerTable" class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th class="text-bold">SL.</th>
                                        <th>Customer Info</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Due Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="creditCustomerTableBody">

                                    </tbody>
                                </table>
                                <div class="loading text-center">
                                    <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                                </div>
                                <table class="table table-bordered table-hover">
                                    <tr>
                                        <td style="text-align: right; font-weight: bold">Total Due </td>
                                        <td><strong class="text-bold totalDue"></strong></td>
                                    </tr>
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
        getCreditCustomers();

        // Get Customers
        function getCreditCustomers() {
            axios.get('/getCreditCustomers').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#creditCustomerTable").DataTable().destroy();
                    $('#creditCustomerTableBody').empty();

                    let total_due = 0;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].customer.name + ' ('+ jsonData[i].customer.number + ', '+ jsonData[i].customer.address+ ')' + "</td>" +
                            "<td>" + '#' + jsonData[i].invoice.invoice_no + "</td>" +
                            "<td>" + jsonData[i].invoice.date + "</td>" +
                            "<td>" + jsonData[i].due_amount + ' Tk' + "</td>" +
                            "<td><a href='#' id='editDue' title='Edit Due' data-id=" + jsonData[i].invoice_id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> <a href='#' title='View Details' class='btn btn-success btn-sm actionBtn' data-id="+ jsonData[i].id +"> <i class='far fa-eye'></i> </a></td>"
                        ).appendTo('#creditCustomerTableBody')
                        total_due += jsonData[i].due_amount;
                    })

                    $('.totalDue').text(total_due+' Tk')
                }

                $("#creditCustomerTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }
    </script>
@endsection
