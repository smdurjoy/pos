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
                            <li class="breadcrumb-item active"><a href=" {{url('/invoice')}} ">Invoice</a></li>
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
                                <h3 class="card-title">Manage Invoices</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addInvoiceModalOpen()"> Add Invoice</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="invoiceTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Customer Info</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
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

    <!-- Add Invoice Modal -->
    <div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modalContent">
                <form id="addInvoiceSelectItem">
                    <div class="modal-body invoiceItemSelectBox">
                        <h5 class="text-center mb-4">Add Invoice</h5>
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="invoice_no">Invoice No</label>
                                    <input type="text" id="invoiceNo" class="form-control" readonly style="background: #d8fdba">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="MM-DD-YYYY" id="date" name="date"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="text" id="stock" name="stock" class="form-control" readonly style="background: #d8fdba">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="category_name">Category</label>
                                    <select class='form-control select2' style='width: 100%;' id='addCategoryName' name='category_name'>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <select class="form-control select2" style="width: 100%;" id="addProductName" name="product_name">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-dark btn-sm" id="addItem"><i class="fa fa-plus-circle"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form id="addInvoiceForm">
                    <div class="modal-body">
                        <table class="table-bordered">
                            <thead>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th width="10%">Unit</th>
                                <th width="10%">Unit Price</th>
                                <th width="17%">Total Price</th>
                                <th width="11%">Action</th>
                            </thead>

                            <tbody id="addRow">

                            </tbody>

                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-right"><h5 class="tableTitle">Discount:</h5></td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm text-right" name="discount_amount" id="discount_amount">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>

                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-right"><h5 class="tableTitle">Grand Total:</h5></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-right" name="estimated_amount" value="0" id="estimated_amount" readonly style="background: #d8fdba">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-row mt-2">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" id="description" name="description" placeholder="Write description .."></textarea>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="form-group col-md-8">
                                <label for="customer_info">Customer Information</label>
                                <select class='form-control select2' style='width: 100%;' id='customer' name='customer'>

                                </select>
                            </div>
                        </div>

                        <div class="form-row customerInfo d-none">
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" placeholder="Customer Name" id="customerName" name="customer_name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" placeholder="Customer Number" id="customerNumber" name="customer_number">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" placeholder="Customer Address" id="customerAddress" name="customer_address">
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="form-group col-md-8">
                                <label for="paid_status">Paid Status</label>
                                <select class='form-control select2' style='width: 100%;' id='paidStatus' name='paid_status'>
                                    <option value="full_paid">Full Paid</option>
                                    <option value="full_due">Full Due</option>
                                    <option value="partial_paid">Partial Paid</option>
                                </select>
                                <input type="number" class="form-control form-control-sm mt-2 d-none paidAmount" placeholder="Enter Paid Amount" name="paid_amount">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="invoiceAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Store</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Handlebars templete -->
    <script id="addRowTemplete" type="text/x-handlebars-template">
        <tr id="addMoreItem">
            <input type="hidden" name="date" id="invoiceDate" value="@{{date}}"/>
            <input type="hidden" name="invoice_no" value="@{{invoice_no}}"/>

            <td>
                <input type="hidden" name="category_id[]" value="@{{category_id}}"/>
                @{{category_name}}
            </td>
            <td>
                <input type="hidden" name="product_id[]" value="@{{product_id}}"/>
                @{{product_name}}
            </td>
            <td>
                <input type="number" min="1" class="form-control form-control-sm text-right selling_qty" name="selling_qty[]" value="1"/>
            </td>
            <td>
                <input type="number" min="1" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value=""/>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm text-right selling_price" name="selling_price[]" value="0" readonly/>
            </td>
            <td>
                <i class="btn btn-danger btn-sm fa fa-window-close" id="removeItem"></i>
            </td>
        </tr>
    </script>
    <script type="text/javascript">
        getInvoices();

        // Get Invoices
        function getInvoices() {
            axios.get('/getInvoices').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#invoiceTable").DataTable().destroy();
                    $('#invoiceTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].payment.customer.name + ' (' + jsonData[i].payment.customer.number + ', '+ jsonData[i].payment.customer.address + ')' + "</td>" +
                            "<td>" + jsonData[i].invoice_no + "</td>" +
                            "<td>" + jsonData[i].date + "</td>" +
                            "<td>" + jsonData[i].description + "</td>" +
                            "<td>" + jsonData[i].payment.total_amount + "</td>" +
                            "<td>" + ((jsonData[i].status == 0) ? ("<span class='badge badge-danger'>Pending</span>") : ("<span class='badge badge-success'>Approved</span>")) + "</td>" +
                            "<td>"+ ((jsonData[i].status == 1) ? '' : ("<a href='#' title='Delete Invoice' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Invoice' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a>")) + " </td>"
                        ).appendTo('#invoiceTableBody')
                    });
                }

                $("#invoiceTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "order": false,
                });

            }).catch((error) => {
                errorMessage(error.message)
            })
        }

        // Date picker format
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        // Add Invoice Modal Open
        function addInvoiceModalOpen() {
            $('#addInvoiceModal').modal('show');

            $('#addCategoryName').empty();
            $('#addCategoryName').append($('<option></option>').html('Loading ..'));

            axios.get('/getProductInfo').then((response) => {
                if(response.status == 200) {

                    const categories = response.data.categories;

                    $('#addCategoryName').empty();
                    $('#addCategoryName').append($('<option></option>').val("").html("Select"));

                    $.each(categories, function (i) {
                        $('#addCategoryName').append($("<option></option>").val(categories[i].id).html(categories[i].name));
                    })
                }

            }).catch((error) => {
                errorMessage(error.message)
            })

            // Get Invoice Number
            axios.get('/getInvoiceNoAndCurrentDate').then((response) => {
                if(response.status == 200) {
                    $("#invoiceNo").val(response.data.invoiceNo);
                    $("#date").val(response.data.date);
                }
            }).catch((error) => {
                errorMessage(error.message)
            })

            // Get Customers
            $('#customer').empty();
            $('#customer').append($('<option></option>').html('Loading ..'));

            axios.get('/getCustomers').then(response => {
                if(response.status == 200) {

                    const customers = response.data;

                    $('#customer').empty();
                    $('#customer').append($('<option></option>').val("").html("Select"));
                    $('#customer').append($('<option></option>').val("0").html("New Customer"));

                    $.each(customers, function (i) {
                        $('#customer').append($("<option></option>").val(customers[i].id).html(customers[i].name+' '+'('+customers[i].number+', '+customers[i].address+')'));
                    })
                }
            }).catch(error => {
                errorMessage(error.message)
            })
        }

        // Get products on category select
        $(document).on('change', '#addCategoryName', function() {
            const category_id = $('#addCategoryName option:selected').val();

            axios.post('/getProducts', {category_id: category_id}).then((response) => {
                $('#addProductName').empty();
                $('#addProductName').append($('<option></option>').html('Loading ..'));

                if(response.status == 200) {
                    const data = response.data;

                    if(data.length < 1 ) {
                        $('#addProductName').empty()
                        $('#addProductName').append($('<option></option>').val("").html("No Products Available"))
                    } else {
                        $('#addProductName').empty()
                        $('#addProductName').append($('<option></option>').val("").html("Select"))
                        $.each(data, function (i) {
                            $('#addProductName').append($('<option></option>').val(data[i].id).html(data[i].name))
                        });
                    }
                }

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        });

        // Get product stoke on product select
        $(document).on('change', '#addProductName', function() {
            const product_id = $('#addProductName option:selected').val();

            axios.post('/getProductStock', {product_id: product_id}).then((response) => {
                if(response.status == 200) {
                    $("#stock").val(response.data);
                }
            }).catch(error => {
                alert(error.data)
            })
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

        // If customer is new
        $(document).on('change', '#customer', function () {
            const customer = $(this).val();
            if(customer == '0') {
                $('.customerInfo').removeClass('d-none');
            } else {
                $('.customerInfo').addClass('d-none');
            }
        });

        // Invoice and edit validation rules and messages
        const validationRules = Object.assign({
            date: {
                required: true,
            },
            category_name: {
                required: true,
            },
            product_name: {
                required: true,
            },
        });

        const validationMsg = Object.assign({
            date: {
                required: "Please pick a date",
            },
            category_name: {
                required: "Please select category",
            },
            product_name: {
                email: "Please enter product name",
            },
        });

        // Add items and get value
        $(document).on('click', '#addItem', function(e) {
            const date = $('#date').val();
            const category_id = $('#addCategoryName option:selected').val();
            const category_name = $('#addCategoryName option:selected').text();
            const product_id = $('#addProductName option:selected').val();
            const product_name = $('#addProductName option:selected').text();
            const invoice_no = $('#invoiceNo').val();

            if(category_name == '' || date == '' || product_name == '') {
                validation('#addInvoiceSelectItem', validationRules, validationMsg);
            } else {
                e.preventDefault();
                const source = $('#addRowTemplete').html();
                const templete = Handlebars.compile(source);
                const data = {
                    date: date,
                    invoice_no: invoice_no,
                    category_id: category_id,
                    category_name: category_name,
                    product_id: product_id,
                    product_name: product_name,
                };

                const html = templete(data);
                $('#addRow').append(html);
            }
        });

        $(document).on('click', '#removeItem', function() {
            $(this).closest('#addMoreItem').remove();
            totalAmount();
        });

        $(document).on('keyup click', '.selling_qty, .unit_price', function() {
            const selling_qty = $(this).closest('tr').find('input.selling_qty').val();
            const unit_price = $(this).closest('tr').find('input.unit_price').val();
            const total_price = unit_price * selling_qty;
            $(this).closest('tr').find('input.selling_price').val(total_price);
            $('#discount_amount').trigger('keyup click')
            totalAmount()
        });

        $(document).on('keyup click', '#discount_amount', function () {
            totalAmount();
        })

        // Calculate total ammout
        function totalAmount() {
            let totalAmount = 0;
            $('.selling_price').each(function() {
                const singlePrice = $(this).val();
                if(!isNaN(singlePrice) && singlePrice.length != 0) {
                    totalAmount += parseFloat(singlePrice);
                }
            });

            let discount_amount = parseFloat( $('#discount_amount').val() );
            if(!isNaN(discount_amount) && discount_amount.length != 0) {
                totalAmount -= parseFloat(discount_amount)
            }

            $('#estimated_amount').val(totalAmount);
        }

        // Add Invoice
        $(document).on('submit', '#addInvoiceForm', function(e) {
            e.preventDefault();
            $('#invoiceAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const data = new FormData(this);

            axios.post('/addInvoice', data).then((response) => {
                if(response.status == 200 && response.data == 0) {
                    $('#invoiceAddConfirmBtn').text('Store').removeClass('disabled');
                    warningMessage('You must select item first !');
                }
                else if(response.status == 200 && response.data == 2) {
                    $('#invoiceAddConfirmBtn').text('Store').removeClass('disabled');
                    warningMessage("Paid amount can't be greater than grand total !");
                }
                else if(response.status == 200 && response.data == 1) {
                    $('#invoiceAddConfirmBtn').text('Store').removeClass('disabled');
                    successMessage('Invoice Added Successfully.');
                    $('#addInvoiceModal').modal('hide');
                    getInvoices();
                } else {
                    $('#invoiceAddConfirmBtn').text('Store').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                $('#invoiceAddConfirmBtn').text('Save').removeClass('disabled');
                errorMessage(error.message)
            })
        });
    </script>
@endsection
