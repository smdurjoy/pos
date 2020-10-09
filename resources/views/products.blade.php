@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/products')}} ">Products</a></li>
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
                                <h3 class="card-title">Manage Products</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addProductModalOpen()"> Add Product</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="productTable" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Supplier</th>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">

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

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addProductForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add Product</h5>
                        <div class="form-group">
                            <label for="supplier">Select Supplier</label>
                            <select class='form-control select2' style='width: 100%;' id='addProductSupplier' name='supplier'>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unit">Select Unit</label>
                            <select class="form-control select2" style="width: 100%;" id="addProductUnit" name="unit">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Select Category</label><br>
                            <select class="form-control select2" style="width: 100%;" id="addProductCategory" name="category">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="phone">Product Name</label>
                            <input type="text" id="addProductName" name="name" class="form-control" placeholder="Product Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="productAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editProductForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Product</h5>
                        <h5 class="d-none" id="productId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="productEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="supplier">Select Supplier</label>
                                    <select class='form-control select2' style='width: 100%;' id='editProductSupplier' name='supplier'>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="unit">Select Unit</label>
                                    <select class="form-control select2" style="width: 100%;" id="editProductUnit" name="unit">

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="category">Select Category</label><br>
                                    <select class="form-control select2" style="width: 100%;" id="editProductCategory" name="category">

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Product Name</label>
                                    <input type="text" id="editProductName" name="name" class="form-control" placeholder="Product Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="productEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getProducts();

        // Get Products
        function getProducts() {
            axios.get('/getProducts').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#productTable").DataTable().destroy();
                    $('#productTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].supplier.name + "</td>" +
                            "<td>" + jsonData[i].category.name + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + jsonData[i].unit.name + "</td>" +
                            "<td><a href='#' id='editProduct' title='Edit Product' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> " + ((jsonData[i].purchase.length == 0) ? ("<a href='#' title='Delete Product' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Product' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a>") : '') + " </td>"
                        ).appendTo('#productTableBody')
                    })
                }

                $("#productTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Add Product Modal Open
        function addProductModalOpen() {
            $('#addProductModal').modal('show');

            $('#addProductSupplier').empty();
            $('#addProductSupplier').append($('<option></option>').html('Loading ..'));

            $('#addProductCategory').empty();
            $('#addProductCategory').append($('<option></option>').html('Loading ..'));

            $('#addProductUnit').empty();
            $('#addProductUnit').append($('<option></option>').html('Loading ..'));

            axios.get('/getProductInfo').then((response) => {
                if(response.status == 200) {

                    const suppliers = response.data.suppliers;
                    const categories = response.data.categories;
                    const units = response.data.units;

                    $('#addProductSupplier').empty();
                    $('#addProductSupplier').append($('<option></option>').val("").html("Select"));

                    $.each(suppliers, function (i) {
                        $('#addProductSupplier').append($("<option data-id="+suppliers[i].id+"></option>").val(suppliers[i].name).html(suppliers[i].name));
                    })

                    $('#addProductCategory').empty();
                    $('#addProductCategory').append($('<option></option>').val("").html("Select"));

                    $.each(categories, function (i) {
                        $('#addProductCategory').append($("<option data-id="+categories[i].id+"></option>").val(categories[i].name).html(categories[i].name));
                    })

                    $('#addProductUnit').empty();
                    $('#addProductUnit').append($('<option></option>').val("").html("Select"));

                    $.each(units, function (i) {
                        $('#addProductUnit').append($("<option data-id="+units[i].id+"></option>").val(units[i].name).html(units[i].name));
                    })
                }

            }).catch((error) => {
                errorMessage(error.message)
            })
        }

        // Product and edit validation rules and messages
        const validationRules = Object.assign({
                    supplier: {
                        required: true,
                    },
                    category: {
                        required: true,
                    },
                    unit: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
        });

        const validationMsg = Object.assign({
                supplier: {
                    required: "Please select product supplier",
                },
                category: {
                    required: "Please select product category",
                },
                unit: {
                    required: "Please select product unit",
                },
                name: {
                    email: "Please enter product name",
                },
        });

        // Add Product
        $(document).on('click', '#productAddConfirmBtn', function(e) {
            const supplier = $('#addProductSupplier option:selected').data('id');
            const category = $('#addProductCategory option:selected').data('id');
            const unit = $('#addProductUnit option:selected').data('id');
            const name = $('#addProductName').val()

            const supplierVal = $('#addProductSupplier').val()
            const categoryVal = $('#addProductCategory').val()
            const unitVal = $('#addProductUnit').val()

            if(supplierVal == '' || categoryVal == '' || unitVal == '' || name == '') {
                validation('#addProductForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#productAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/addProduct', {
                    supplier: supplier,
                    category: category,
                    unit: unit,
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#productAddConfirmBtn').text('Save').removeClass('disabled');
                        $('#addProductModal').modal('hide');
                        successMessage('Product Added Successfully.')
                        getProducts();
                    } else {
                        $('#productAddConfirmBtn').text('Save').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#productAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                });
            }
        });

        // Edit Product Modal Open
        $(document).on('click', '#editProduct', function(e) {
            $('#editProductModal').modal('show');

            const id = $(this).data('id');
            getProductDetails(id);
        });

        // Get Product details
        function getProductDetails(id) {
            axios.get('/getProductDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#productEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    const suppliers = response.data.suppliers;
                    const categories = response.data.categories;
                    const units = response.data.units;
                    const name = response.data.product.name;
                    const supplier_id = response.data.product.supplier_id;
                    const category_id = response.data.product.category_id;
                    const unit_id = response.data.product.unit_id;


                    $('#editProductSupplier').empty();
                    $('#editProductSupplier').append($('<option></option>').val("").html("Select"));

                    $.each(suppliers, function (i) {
                        $('#editProductSupplier').append($("<option data-id="+suppliers[i].id+ " " + ((suppliers[i].id == supplier_id) ? 'selected' : '') + "></option>").val(suppliers[i].name).html(suppliers[i].name));
                    })

                    $('#editProductCategory').empty();
                    $('#editProductCategory').append($('<option></option>').val("").html("Select"));

                    $.each(categories, function (i) {
                        $('#editProductCategory').append($("<option data-id="+categories[i].id+ " " + ((categories[i].id == category_id) ? 'selected' : '') + "></option>").val(categories[i].name).html(categories[i].name));
                    })

                    $('#editProductUnit').empty();
                    $('#editProductUnit').append($('<option></option>').val("").html("Select"));

                    $.each(units, function (i) {
                        $('#editProductUnit').append($("<option data-id="+units[i].id+ " " + ((units[i].id == unit_id) ? 'selected' : '') + "></option>").val(units[i].name).html(units[i].name));
                    })

                    $('#editProductName').val(name);
                    $('#productEditConfirmBtn').data('id', id);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Product Edit Confirm Method
        $(document).on('click', '#productEditConfirmBtn', function(e) {
            const id = $(this).data('id');
            const supplier = $('#editProductSupplier option:selected').data('id');
            const category = $('#editProductCategory option:selected').data('id');
            const unit = $('#editProductUnit option:selected').data('id');
            const name = $('#editProductName').val()

            const supplierVal = $('#editProductSupplier').val();
            const categoryVal = $('#editProductCategory').val();
            const unitVal = $('#editProductUnit').val();

            if(supplierVal == '' || categoryVal == '' || unitVal == '' || name == '') {
                validation('#editProductForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#productEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/updateProductDetails', {
                    id: id,
                    supplier: supplier,
                    category: category,
                    unit: unit,
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#productEditConfirmBtn').text('Update').removeClass('disabled');
                        $('#editProductModal').modal('hide');
                        successMessage('Product Updated Successfully.')
                        getProducts();
                    } else {
                        $('#productEditConfirmBtn').text('Update').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#productEditConfirmBtn').text('Update').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                });
            }
        });
    </script>
@endsection
