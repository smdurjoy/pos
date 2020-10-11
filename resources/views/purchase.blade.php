@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Purchase</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/purchase')}} ">Purchase</a></li>
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
                                <h3 class="card-title">Manage Purchase</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addPurchaseModalOpen()"> Add Purchase</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="purchaseTable" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">SL.</th>
                                            <th class="text-bold">Purchase No</th>
                                            <th class="text-bold">Date</th>
                                            <th class="text-bold">Supplier</th>
                                            <th class="text-bold">Category</th>
                                            <th class="text-bold">Product Name</th>
                                            <th class="text-bold">Quantity</th>
                                            <th class="text-bold">Unit Price</th>
                                            <th class="text-bold">Buying Price</th>
                                            <th class="text-bold">Status</th>
                                            <th class="text-bold">Description</th>
                                            <th class="text-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchaseTableBody">

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

    <!-- Add Purchase Modal -->
    <div class="modal fade" id="addPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="addPurchaseSelectItem">
                    <div class="modal-body purchaseItemSelectBox">
                        <h5 class="text-center mb-4">Add Purchase</h5>
                        <div class="row">
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
                                <div class="form-group">
                                    <label for="supplier_name">Supplier</label>
                                    <select class="form-control select2" style="width: 100%;" id="addSupplierName" name="supplier_name">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <select class="form-control select2" style="width: 100%;" id="addProductName" name="product_name">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_no">Purchase No</label>
                                    <input type="text" id="purchaseNo" name="purchase_no" class="form-control" placeholder="Purchase No">
                                </div>
                                <div class="form-group">
                                    <label for="category_name">Category</label>
                                    <select class='form-control select2' style='width: 100%;' id='addCategoryName' name='category_name'>

                                    </select>
                                </div>
                                <button class="btn btn-dark btn-sm" id="addItem"><i class="fa fa-plus-circle"></i> Add Item</button>
                            </div>
                        </div>
                    </div>
                </form>

                <form id="addPurchaseForm">
                    <div class="modal-body">
                        <table>
                            <thead>
                                <th class="text-bold">Category</th>
                                <th class="text-bold">Product Name</th>
                                <th width="10%" class="text-bold">Unit</th>
                                <th width="10%" class="text-bold">Unit Price</th>
                                <th class="text-bold">Description</th>
                                <th width="10%" class="text-bold">Total Price</th>
                                <th class="text-bold">Action</th>
                            </thead>

                            <tbody id="addRow">

                            </tbody>

                            <tbody>
                                <tr>
                                    <td colspan="5"></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-right" name="estimated_amount" value="0" id="estimated_amount" readonly style="background: #d8fdba">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="purchaseAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
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
            <input type="hidden" name="date[]" id="purchaseDate" value="@{{date}}"/>
            <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}"/>
            <input type="hidden" name="purchase_no[]" value="@{{purchase_no}}"/>

            <td>
                <input type="hidden" name="category_id[]" value="@{{category_id}}"/>
                @{{category_name}}
            </td>
            <td>
                <input type="hidden" name="product_id[]" value="@{{product_id}}"/>
                @{{product_name}}
            </td>
            <td>
                <input type="number" min="1" class="form-control form-control-sm text-right buying_qt" name="buying_qt[]" value="1"/>
            </td>
            <td>
                <input type="number" min="1" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value=""/>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="description[]"/>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm text-right buying_price" name="buying_price[]" value="0" readonly/>
            </td>
            <td>
                <i class="btn btn-danger btn-sm fa fa-window-close" id="removeItem"></i>
            </td>
        </tr>
    </script>

    <!-- Custom js -->
    <script type="text/javascript">
        getPurchase();

        // Get Purchase
        function getPurchase() {
            axios.get('/getPurchases').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    console.log(jsonData)
                    $("#purchaseTable").DataTable().destroy();
                    $('#purchaseTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].purchase_number + "</td>" +
                            "<td>" + jsonData[i].date + "</td>" +
                            "<td>" + jsonData[i].supplier.name + "</td>" +
                            "<td>" + jsonData[i].category.name + "</td>" +
                            "<td>" + jsonData[i].product.name + "</td>" +
                            "<td>" + jsonData[i].buying_quantity + ' ' + jsonData[i].product.unit.name +"</td>" +
                            "<td>" + jsonData[i].unit_price + "</td>" +
                            "<td>" + jsonData[i].buying_price + "</td>" +
                            "<td>" + ((jsonData[i].status == 0) ? ("<span class='badge badge-danger'>Pending</span>") : ("<span class='badge badge-success'>Approved</span>")) + "</td>" +
                            "<td>" + ((jsonData[i].description == null) ? '' : jsonData[i].description) + "</td>" +
                            "<td>"+ ((jsonData[i].status == 1) ? ("<button type='button' class='btn btn-danger btn-sm actionBtn' disabled><i class='far fa-trash-alt deleteButton'></i></button>") : ("<button href='#' title='Delete Purchase' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Purchase' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </button>")) + " </td>"
                        ).appendTo('#purchaseTableBody')
                    })
                }

                $("#purchaseTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Date picker format
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        // Add Purchase Modal Open
        function addPurchaseModalOpen() {
            $('#addPurchaseModal').modal('show');

            $('#addSupplierName').empty();
            $('#addSupplierName').append($('<option></option>').html('Loading ..'));

            axios.get('/getProductInfo').then((response) => {
                if(response.status == 200) {

                    const suppliers = response.data.suppliers;

                    $('#addSupplierName').empty();
                    $('#addSupplierName').append($('<option></option>').val("").html("Select"));

                    $.each(suppliers, function (i) {
                        $('#addSupplierName').append($("<option></option>").val(suppliers[i].id).html(suppliers[i].name));
                    })
                }

            }).catch((error) => {
                errorMessage(error.message)
            })
        }

        // Get categories on supplier select
        $(document).on('change', '#addSupplierName', function() {
            const supplier_id = $('#addSupplierName option:selected').val();

            axios.post('/getCategories', {supplier_id: supplier_id}).then((response) => {
                $('#addCategoryName').empty();
                $('#addCategoryName').append($('<option></option>').html('Loading ..'));

                if(response.status == 200) {
                    const data = response.data;

                    if(data.length < 1 ) {
                        $('#addCategoryName').empty()
                        $('#addCategoryName').append($('<option></option>').val("").html("No Categories Available"))
                    } else {
                        $('#addCategoryName').empty()
                        $('#addCategoryName').append($('<option></option>').val("").html("Select"))
                        $.each(data, function (i) {
                            $('#addCategoryName').append($("<option></option>").val(data[i].category_id).html(data[i].category.name))
                        });
                    }
                }

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        });

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

        // Purchase and edit validation rules and messages
        const validationRules = Object.assign({
                    date: {
                        required: true,
                    },
                    supplier_name: {
                        required: true,
                    },
                    category_name: {
                        required: true,
                    },
                    product_name: {
                        required: true,
                    },
                    purchase_no: {
                        required: true,
                    },
        });

        const validationMsg = Object.assign({
                date: {
                    required: "Please pick a date",
                },
                supplier_name: {
                    required: "Please select supplier",
                },
                category_name: {
                    required: "Please select category",
                },
                product_name: {
                    email: "Please enter product name",
                },
                purchase_no: {
                    email: "Please enter purchase_no",
                },
        });

        // Add items and get value
        $(document).on('click', '#addItem', function(e) {
            const date = $('#date').val();
            const supplier_id = $('#addSupplierName option:selected').val();
            const supplier_name = $('#addSupplierName option:selected').text();
            const category_id = $('#addCategoryName option:selected').val();
            const category_name = $('#addCategoryName option:selected').text();
            const product_id = $('#addProductName option:selected').val();
            const product_name = $('#addProductName option:selected').text();
            const purchase_no = $('#purchaseNo').val();

            if(category_name == '' || date == '' || supplier_name == '' || product_name == '' || purchase_no == '') {
                validation('#addPurchaseSelectItem', validationRules, validationMsg);
            } else {
                e.preventDefault();
                const source = $('#addRowTemplete').html();
                const templete = Handlebars.compile(source);
                const data = {
                    date: date,
                    purchase_no: purchase_no,
                    supplier_id: supplier_id,
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

        $(document).on('keyup click', '.buying_qt, .unit_price', function() {
            const buying_qt = $(this).closest('tr').find('input.buying_qt').val();
            const unit_price = $(this).closest('tr').find('input.unit_price').val();
            const total_price = unit_price * buying_qt;
            $(this).closest('tr').find('input.buying_price').val(total_price);
            totalAmount();
        });

        // Calculate total ammout
        function totalAmount() {
            let totalAmount = 0;
            $('.buying_price').each(function() {
                const singlePrice = $(this).val();
                if(!isNaN(singlePrice) && singlePrice.length != 0) {
                    totalAmount += parseFloat(singlePrice);
                }
            });

            $('#estimated_amount').val(totalAmount);
        }

        // Add Purchase
        $(document).on('submit', '#addPurchaseForm', function(e) {
            e.preventDefault();
            $('#purchaseAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const data = new FormData(this);

            axios.post('/addPurchase', data).then((response) => {
                if(response.status == 200 && response.data == 0) {
                    $('#purchaseAddConfirmBtn').text('Save').removeClass('disabled');
                    warningMessage('You must select item first !');
                }
                else if(response.status == 200 && response.data == 1) {
                    $('#purchaseAddConfirmBtn').text('Save').removeClass('disabled');
                    successMessage('Purchase Added Successfully.');
                    $('#addPurchaseModal').modal('hide');
                    getPurchase();
                } else {
                    $('#purchaseAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                $('#purchaseAddConfirmBtn').text('Save').removeClass('disabled');
                errorMessage(error.message)
            })
        });
    </script>
@endsection
