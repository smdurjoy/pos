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
                            <li class="breadcrumb-item active"><a href=" {{url('/paid-customers')}} ">Paid Customers</a></li>
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
                                <h3 class="card-title">Paid Customers</h3>
                                <a target="_blank" href="{{ url('print/paid-customers') }}" class="btn btn-dark btn-sm" style="float: right"><i class="fa fa-print"></i> Generate PDF</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="paidCustomerTable" class="table table-bordered table-sm">
                                    <thead>
                                    <tr>
                                        <th class="text-bold">SL.</th>
                                        <th class="text-bold">Customer Info</th>
                                        <th class="text-bold">Invoice No</th>
                                        <th class="text-bold">Date</th>
                                        <th class="text-bold">Paid Amount</th>
                                        <th class="text-bold">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="paidCustomerTableBody">

                                    </tbody>
                                </table>
                                <div class="loading text-center">
                                    <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                                </div>
                                <table class="table table-bordered" style="background: #eee">
                                    <tr>
                                        <td style="text-align: right; font-weight: bold; width: 50%">Total Paid Amount </td>
                                        <td><strong class="text-bold totalPaid"></strong></td>
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

    <!-- Payment Details Modal -->
    <div class="modal fade" id="invoiceDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modalContent">
                <div class="modal-body p-4">
                    <h5 class="text-center mb-4">Payment Summary</h5>
                    <div class="pDetailsLoading text-center">
                        <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                    </div>
                    <div class="row d-none" id="paymentSummary">
                        <div class="col-md-12 paymentDetails">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                    <div class="paidCustomerPdf">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getPaidCustomers();

        // Get Customers
        function getPaidCustomers() {
            axios.get('/getPaidCustomers').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#paidCustomerTable").DataTable().destroy();
                    $('#paidCustomerTableBody').empty();

                    let total_paid = 0;
                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].customer.name + ' ('+ jsonData[i].customer.number + ', '+ jsonData[i].customer.address+ ')' + "</td>" +
                            "<td>" + '#' + jsonData[i].invoice.invoice_no + "</td>" +
                            "<td>" + jsonData[i].invoice.date + "</td>" +
                            "<td>" + jsonData[i].paid_amount + ' Tk' + "</td>" +
                            "<td><a href='javascript:void(0)' id='invoiceDetails' title='View Details' class='btn btn-success btn-sm actionBtn' data-id="+ jsonData[i].invoice_id +"> <i class='far fa-eye'></i> </a></td>"
                        ).appendTo('#paidCustomerTableBody')
                        total_paid += jsonData[i].paid_amount;
                    })

                    $('.totalPaid').text(total_paid+' Tk')
                }

                $("#paidCustomerTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        $(document).on('click', '#invoiceDetails', function () {
            const id = $(this).data('id');
            $('#invoiceDetailsModal').modal('show');
            getInvoiceDetails(id);
        })

        function getInvoiceDetails(id) {
            axios.post('/getPaidCustomersDetails', {id: id}).then(response => {
                if(response.status == 200) {
                    $('#paymentSummary').removeClass('d-none');
                    $('.pDetailsLoading').addClass('d-none')
                    const data = response.data[0];
                    const invoiceDetails = response.data[0]['invoice_details'];
                    const customer = response.data[0]['payment']['customer'];
                    const payment = response.data[0]['payment'];
                    console.log(payment)

                    $('.paymentDetails').html(
                        " <table class='table table-bordered table-sm'><tr><td class='customerName'><span style='font-weight: bold;'>Customer:</span> "+ customer.name +"</td><td><span style='font-weight: bold;'>Invoice No:</span> #"+ data.invoice_no +" </td></tr><tr><td><span style='font-weight: bold;'>Mobile:</span> "+ customer.number +"</td><td><span style='font-weight: bold;'>Date:</span> "+ data.date +" </td></tr><tr><td><span style='font-weight: bold;'>Address:</span> "+ customer.address +"</td></tr></table><table width='100%' class='table table-bordered table-sm'><thead><tr><th class='text-bold'>SL.</th><th class='text-bold'>Category</th><th class='text-bold'>Product Name </th><th class='text-bold'>Unit</th><th class='text-bold'>Unit Price</th><th class='text-bold'>Amount</th></tr></thead><tbody id='payInvoiceDetails'></tbody><tbody><tr><td colspan='5' class='text-bold'>Total Amount</td><td class='text-bold totalAmount'></td></tr><tr><td colspan='5'>Discount Amount</td><td>"+ payment.discount_amount +"</td></tr><tr><td colspan='5'><span style='font-weight: bold;'>Paid Amount</span></td><td><span style='font-weight: bold;'>"+ payment.paid_amount +"</span></td></tr></tbody></table>"
                    )

                    let index = 1;
                    let total_amount = 0;
                    $.each(invoiceDetails, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + invoiceDetails[i].category.name + "</td>" +
                            "<td>" + invoiceDetails[i].product.name + "</td>" +
                            "<td>" + invoiceDetails[i].product.quantity + "</td>" +
                            "<td>" + invoiceDetails[i].unit_price + "</td>" +
                            "<td>" + invoiceDetails[i].selling_price + "</td>"
                        ).appendTo('#payInvoiceDetails');
                        total_amount += invoiceDetails[i].selling_price
                    });
                    $('.totalAmount').text(total_amount)

                    let url = '{{ url('/print/paid-customer-invoice/:id/:invoiceNum') }}';
                    url = url.replace(':id', id);
                    url = url.replace(':invoiceNum', data.invoice_no);
                    $('.paidCustomerPdf').html(
                        " <a href='"+ url +"' target='_blank' id='generatePdf' class='btn btn-danger btn-sm'>Generate PDF</a> "
                    )
                }
            }).catch(error => {
                errorMessage(error.message)
            })
        }
    </script>
@endsection
