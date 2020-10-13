@extends('layouts.app')
@section('title', 'Credit Customers')

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
                            <li class="breadcrumb-item active"><a href=" {{url('/credit-customers')}} ">Credit Customers</a></li>
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
                                <table id="creditCustomerTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-bold">SL.</th>
                                        <th class="text-bold">Customer Info</th>
                                        <th class="text-bold">Invoice No</th>
                                        <th class="text-bold">Date</th>
                                        <th class="text-bold">Due Amount</th>
                                        <th class="text-bold">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="creditCustomerTableBody">

                                    </tbody>
                                </table>
                                <div class="loading text-center">
                                    <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                                </div>
                                <table class="table table-bordered" style="background: #eee">
                                    <tr>
                                        <td style="text-align: right; font-weight: bold; width: 50%">Total Due Amount</td>
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

    <!-- Edit Invoice Modal -->
    <div class="modal fade" id="editDueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modalContent">
                <form id="editCustomerInvoice">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Invoice</h5>
                        <h5 class="d-none" id="CustomerId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="dueEditDetails">
                            <div class="col-md-12 details">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paid_status">Paid Status</label>
                                    <select class='form-control select2' style='width: 100%;' id='paidStatus' name='paid_status'>
                                        <option value="">Select</option>
                                        <option value="full_paid">Full Paid</option>
                                        <option value="partial_paid">Partial Paid</option>
                                    </select>
                                    <input type="number" class="form-control form-control-sm mt-2 d-none paidAmount" placeholder="Enter Paid Amount" name="paid_amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="DD-MM-YYYY" id="date" name="date"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="invoiceUpdateBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <div class="pdfUrl">

                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].customer.name + ' ('+ jsonData[i].customer.number + ', '+ jsonData[i].customer.address+ ')' + "</td>" +
                            "<td>" + '#' + jsonData[i].invoice.invoice_no + "</td>" +
                            "<td>" + jsonData[i].invoice.date + "</td>" +
                            "<td>" + jsonData[i].due_amount + ' Tk' + "</td>" +
                            "<td><a href='javascript:void(0)' id='editDue' title='Edit Due' data-id=" + jsonData[i].invoice_id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> <a href='javascript:void(0)' id='paymentDetails' title='Payment Summary' class='btn btn-success btn-sm actionBtn' data-id="+ jsonData[i].invoice_id +"> <i class='far fa-eye'></i> </a></td>"
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

        $(document).on('click', '#editDue', function () {
            const id = $(this).data('id');
            $('#editDueModal').modal('show');
            getEditInvoiceDetails(id)
        });

        function getEditInvoiceDetails(id) {
            axios.post('/getEditInvoiceDetails', {id: id}).then(response => {
                if(response.status == 200) {
                    $('#dueEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none')
                    $('#invoiceUpdateBtn').data('id', id);
                    const data = response.data;
                    const invoiceDetails = response.data[0]['invoice_details'];
                    const paymentDetails = response.data[0]['payment'];

                    $('.details').html(
                        " <table class='table table-bordered table-sm'><tr><td class='customerName'><span style='font-weight: bold;'>Customer:</span> "+ paymentDetails.customer.name +"</td><td><span style='font-weight: bold;'>Invoice No:</span> #"+ data[0]['invoice_no'] +" </td></tr><tr><td><span style='font-weight: bold;'>Mobile:</span> "+ paymentDetails.customer.number +"</td><td><span style='font-weight: bold;'>Date:</span> "+ data[0]['date'] +" </td></tr><tr><td><span style='font-weight: bold;'>Address:</span> "+ paymentDetails.customer.address +"</td></tr></table><table width='100%' class='table table-bordered table-sm'><thead><tr><th class='text-bold'>SL.</th><th class='text-bold'>Category</th><th class='text-bold'>Product Name</th><th class='text-bold'>Qty</th><th class='text-bold'>Unit Price</th><th class='text-bold'>Amount</th></tr></thead><tbody id='invoiceDetails'></tbody><tbody><tr><td colspan='5' class='text-bold'><span>Total Amount</span></td><td><span style='font-weight: bold;'>100000</span></td></tr><tr><td colspan='5'>Less Discount</td><td>"+ ((paymentDetails.discount_amount == null) ? 0 : paymentDetails.discount_amount) +"</td></tr><tr><td colspan='5'>Paid Amount</td><td>"+ paymentDetails.paid_amount +"</td></tr><tr><td colspan='5'>Due Amount</td><td>"+ paymentDetails.due_amount +"</td></tr><tr><td colspan='5'><span style='font-weight: bold;'>Net Payable Amount</span></td><td><span style='font-weight: bold;'>"+ paymentDetails.total_amount +"</span></td></tr></tbody></table><input type='hidden' name='due_amount' value='"+ paymentDetails.due_amount +"'>"
                    )

                    let index = 1;
                    $.each(invoiceDetails, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + invoiceDetails[i].category.name + "</td>" +
                            "<td>" + invoiceDetails[i].product.name + "</td>" +
                            "<td>" + invoiceDetails[i].selling_quantity + "</td>" +
                            "<td>" + invoiceDetails[i].unit_price + ' Tk' + "</td>" +
                            "<td>" + invoiceDetails[i].selling_price + ' Tk' + "</td>"
                        ).appendTo('#invoiceDetails');
                    });

                    $('.customerName').html("<span style='font-weight: bold;'>Customer:</span> "+ paymentDetails.customer.name + " ")
                }
            }).catch(error => {
                errorMessage(error.message);
            })
        }

        // Date picker format
        $('#reservationdate').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        // If customer paid partial amount
        $(document).on('change', '#paidStatus', function () {
            const status = $(this).val();
            if(status == 'partial_paid') {
                $('.paidAmount').removeClass('d-none');
            } else {
                $('.paidAmount').addClass('d-none');
            }
        });

        // Invoice edit validation rules and messages
        const validationRules = Object.assign({
            paid_status: {
                required: true,
            },
            paid_amount: {
                required: true,
            },
            date: {
                required: true,
            },
        });

        const validationMsg = Object.assign({
            paid_status: {
                required: "Please select paid status",
            },
            paid_amount: {
                required: "Please select paid status",
            },
            date: {
                required: "Please pick a date",
            },
        });

        validation('#editCustomerInvoice', validationRules, validationMsg)

        $(document).on('submit', '#editCustomerInvoice', function (e) {
            e.preventDefault();
            $('#invoiceUpdateBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const id = $('#invoiceUpdateBtn').data('id');
            const data = new FormData(this);
            data.append('invoice_id', id);
            axios.post('/updateCustomerInvoice', data).then(response => {
                if(response.status == 200 & response.data == 2) {
                    $('#invoiceUpdateBtn').text('Update').removeClass('disabled');
                    warningMessage("Paid amount can't be greater than due amount !")
                } else if(response.status == 200 && response.data == 1) {
                    successMessage('Invoice Updated Successfully.')
                    $('#invoiceUpdateBtn').text('Update').removeClass('disabled');
                    $('#editDueModal').modal('hide');
                    $('#editCustomerInvoice').trigger('reset');
                    getCreditCustomers();
                } else {
                    $('#invoiceUpdateBtn').text('Update').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch(error => {
                $('#invoiceUpdateBtn').text('Update').removeClass('disabled');
                errorMessage(error.message)
            })
        })

        $(document).on('click', '#paymentDetails', function () {
            const id = $(this).data('id');
            $('#paymentDetailsModal').modal('show');
            getPaymentDetails(id);
        })

        function getPaymentDetails(id) {
            axios.post('/getInvoiceDetails', {id: id}).then(response => {
                if(response.status == 200) {
                    $('#paymentSummary').removeClass('d-none');
                    $('.pDetailsLoading').addClass('d-none')
                    const data = response.data;
                    const paymentDetails = response.data[0]['payment_details'];
                    const payment = response.data[0]['payment'];
                    console.log(data);

                    $('.paymentDetails').html(
                        " <table class='table table-bordered table-sm'><tr><td class='customerName'><span style='font-weight: bold;'>Customer:</span> "+ payment.customer.name +"</td><td><span style='font-weight: bold;'>Invoice No:</span> #"+ data[0]['invoice_no'] +" </td></tr><tr><td><span style='font-weight: bold;'>Mobile:</span> "+ payment.customer.number +"</td><td><span style='font-weight: bold;'>Date:</span> "+ data[0]['date'] +" </td></tr><tr><td><span style='font-weight: bold;'>Address:</span> "+ payment.customer.address +"</td></tr></table><table width='100%' class='table table-bordered table-sm'><thead><tr><th class='text-bold'>SL.</th><th class='text-bold'>Date</th><th class='text-bold'>Amount</th></tr></thead><tbody id='payInvoiceDetails'></tbody><tbody><tr><td colspan='2' class='text-bold'>Paid Amount</td><td class='text-bold'>"+ payment.paid_amount +"</td></tr><tr><td colspan='2'>Due Amount</td><td>"+ payment.due_amount +"</td></tr><tr><td colspan='2'><span style='font-weight: bold;'>Net Payable Amount</span></td><td><span style='font-weight: bold;'>"+ payment.total_amount +"</span></td></tr></tbody></table><input type='hidden' name='due_amount' value='"+ payment.due_amount +"'>"
                    )

                    let index = 1;
                    $.each(paymentDetails, function (i) {
                        const date = paymentDetails[i].date;
                        const newDateFormat = date.split("-").reverse().join("-");
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + newDateFormat + "</td>" +
                            "<td>" + paymentDetails[i].current_paid_amount + "</td>"
                        ).appendTo('#payInvoiceDetails');
                    });

                    let url = '{{ url('/print/customer-payment-summary/:id/:invoiceNum') }}';
                    url = url.replace(':id', id);
                    url = url.replace(':invoiceNum', data[0]['invoice_no']);
                    $('.pdfUrl').html(
                        " <a href='"+ url +"' target='_blank' id='generatePdf' class='btn btn-danger btn-sm'><i class='fa fa-print'></i> Generate PDF</a> "
                    )
                }
            }).catch(error => {
                errorMessage(error.message)
            })
        }
    </script>
@endsection
