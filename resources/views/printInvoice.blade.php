@extends('layouts.app')
@section('title', 'Print Invoice')

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
                                <table id="printInvoiceTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">Id</th>
                                            <th class="text-bold">Customer Info</th>
                                            <th class="text-bold">Invoice No</th>
                                            <th class="text-bold">Date</th>
                                            <th class="text-bold">Description</th>
                                            <th class="text-bold">Amount</th>
                                            <th class="text-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="printInvoiceTableBody">

                                    </tbody>
                                </table>
                                <div class="loadingPrintInvoice text-center">
                                    <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                                </div>
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
        getInvoice();
        // Get Invoice
        function getInvoice() {
            axios.get('/getPrintInvoices').then((response) => {
                if(response.status == 200) {
                    $('.loadingPrintInvoice').addClass('d-none');
                    const jsonData = response.data;
                    $("#printInvoiceTable").DataTable().destroy();
                    $('#printInvoiceTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        let url = '{{ url('/print/invoice/:invoiceNum') }}';
                        url = url.replace(':invoiceNum', jsonData[i].invoice_no);
                        const date = jsonData[i].date;
                        const newDateFormat = date.split("-").reverse().join("-");
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].payment.customer.name + "</td>" +
                            "<td>#" + jsonData[i].invoice_no + "</td>" +
                            "<td>" + newDateFormat + "</td>" +
                            "<td>" + ((jsonData[i].description == null) ? '' : jsonData[i].description) + "</td>" +
                            "<td>" + jsonData[i].payment.total_amount + " Tk</td>" +
                            "<td><a href='"+ url +"' title='Print Invoice' class='btn btn-info btn-sm actionBtn' target='_blank'> <i class='fas fa-print deleteButton'></i> </a></td>"
                        ).appendTo('#printInvoiceTableBody')
                    })
                }

                $("#printInvoiceTable").DataTable({
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
