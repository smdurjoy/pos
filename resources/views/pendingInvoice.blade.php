@extends('layouts.app')
@section('title', 'Pending Invoices')

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
                            <li class="breadcrumb-item active"><a href=" {{url('/pending-invoice')}} ">Pending Invoice</a></li>
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
                                <h3 class="card-title">Pending Invoices</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="invoiceTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-bold">SL.</th>
                                        <th class="text-bold">Customer Info</th>
                                        <th class="text-bold">Invoice No</th>
                                        <th class="text-bold">Date</th>
                                        <th class="text-bold">Description</th>
                                        <th class="text-bold">Amount</th>
                                        <th class="text-bold">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="invoiceTableBody">

                                    </tbody>
                                </table>
                                <div class="loading text-center">
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

    <!-- Approve Invoice Modal -->
    <div class="modal fade" id="invoiceApproveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modalContent">
                <form id="invoiceApproveForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4" id="invoiceNum"></h5>
                        <div class="loadingApprove text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="approveDetails">
                            <div class="col-md-12 invoiceInfo">

                            </div>
                            <div class="col-md-12 mt-4">
                                <table style="width: 100%" class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">SL.</th>
                                            <th class="text-bold">Category</th>
                                            <th class="text-bold">Product Name</th>
                                            <th class="currentStock text-bold">Current Stock</th>
                                            <th class="text-bold">Quantity</th>
                                            <th class="text-bold">Unit Price</th>
                                            <th class="text-bold">Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody id="invoiceDetails">

                                    </tbody>

                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-right text-bold">Sub Total:</td>
                                            <td id="subTotal"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right text-bold">Discount:</td>
                                            <td id="discount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right text-bold">Paid Amount:</td>
                                            <td id="paidAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right text-bold">Due Amount:</td>
                                            <td id="dueAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right text-bold">Grand Total:</td>
                                            <td id="grandTotal"></td>
                                        </tr>
                                    </tbody>
                                    <tbody id="info">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="invoiceApproveBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getInvoice();

        // Get Invoice
        function getInvoice() {
            axios.get('/pendingInvoiceList').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    console.log(jsonData);
                    $("#invoiceTable").DataTable().destroy();
                    $('#invoiceTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        let date = jsonData[i].date;
                        let newDateFormat = date.split("-").reverse().join("-");
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].payment.customer.name + ' (' + jsonData[i].payment.customer.number + ', '+ jsonData[i].payment.customer.address + ')' + "</td>" +
                            "<td>#" + jsonData[i].invoice_no + "</td>" +
                            "<td>" + newDateFormat + "</td>" +
                            "<td>" + ((jsonData[i].description == null) ? '' : jsonData[i].description) + "</td>" +
                            "<td>" + jsonData[i].payment.total_amount + " Tk</td>" +
                            "<td><button href='#' title='Approve Invoice' class='btn btn-success btn-sm actionBtn approveInvoice' data-id="+ jsonData[i].id +"> <i class='fa fa-check-circle'></i> </button></td>"
                        ).appendTo('#invoiceTableBody')
                    })
                }

                $("#invoiceTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        $(document).on('click', '.approveInvoice', function () {
            $('#invoiceApproveModal').modal('show');
            const id = $(this).data('id');

            axios.get('/getApproveInvoiceDetails/'+id).then(response => {
                if(response.status == 200) {
                    $('.loadingApprove').addClass('d-none');
                    $('#approveDetails').removeClass('d-none');

                    const data = response.data;

                    let date = data.date;
                    let newDateFormat = date.split("-").reverse().join("-");
                    $('#invoiceNum').text('Invoice No #'+data.invoice_no+' ('+newDateFormat+')')

                    $('.invoiceInfo').html(
                        "<table class='table table-bordered table-sm'><tr><td><span style='font-weight: bold;'>Customer: </span>" + data.payment.customer.name + "</td><td><span style='font-weight: bold;'>Address: </span>" + data.payment.customer.address + "</td></tr><tr><td><span style='font-weight: bold;'>Mobile:</span> " + data.payment.customer.number + "</td><td><span style='font-weight: bold;'>Description: </span> " + ((data.description == null) ? '' : data.description) + " </td></tr></table>"
                    )

                    const invoiceDetails = response.data.invoice_details;
                    $('#invoiceDetails').empty();
                    let subTotal = 0;
                    let index = 1;
                    $.each(invoiceDetails, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + invoiceDetails[i].category.name + "</td>" +
                            "<td>" + invoiceDetails[i].product.name  + "</td>" +
                            "<td class='currentStock'>" + invoiceDetails[i].product.quantity  + "</td>" +
                            "<td>" + invoiceDetails[i].selling_quantity  + "</td>" +
                            "<td>" + invoiceDetails[i].unit_price + "</td>" +
                            "<td>" + invoiceDetails[i].selling_price + "</td>"
                        ).appendTo('#invoiceDetails');
                        subTotal += invoiceDetails[i].selling_price;

                        $('#info').html(
                            "<input type='hidden' name='category_id[]' value='"+invoiceDetails[i].category_id +"'><input type='hidden' name='product_id[]' value='"+invoiceDetails[i].product_id +"'><input type='hidden' name='selling_qty["+invoiceDetails[i].id+"]' value='"+invoiceDetails[i].selling_quantity +"'><input type='hidden' name='id' value='"+data.id +"'>"
                        )
                    });

                    $('#subTotal').text(subTotal);
                    $('#discount').text(((data.payment.discount_amount == null) ? 0 : data.payment.discount_amount));
                    $('#paidAmount').text(data.payment.paid_amount);
                    $('#dueAmount').text(data.payment.due_amount);
                    $('#grandTotal').text(data.payment.total_amount);
                } else {
                    errorMessage('Something Went Wrong !')
                }

            }).catch(error => {
                errorMessage('Something Went Wrong !')
            })
        });

        $(document).on('submit', '#invoiceApproveForm', function (e) {
            e.preventDefault();
            $('#invoiceApproveBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const data = new FormData(this);

            axios.post('/approveInvoice', data).then(response => {
                if(response.status == 200 && response.data == 1) {
                    $('#invoiceApproveBtn').text('Approve').removeClass('disabled');
                    $('#invoiceApproveModal').modal('hide');
                    successMessage('Invoice Approved Successfully.')
                    getInvoice();
                }
                else if(response.status == 200 & response.data == 2) {
                    $('#invoiceApproveBtn').text('Approve').removeClass('disabled');
                    warningMessage('Product is out of stock');
                } else {
                    $('#invoiceApproveBtn').text('Approve').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch(error => {
                $('#invoiceApproveBtn').text('Approve').removeClass('disabled');
                errorMessage(error.message)
            })
        });
    </script>
@endsection
