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
                                <h3 class="card-title">View Products</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addProductModalOpen()"> Add Product</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="productTable" class="table table-bordered table-striped">
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
                            "<td><a href='#' id='editProduct' title='Edit Product' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> <a href='#' title='Delete Product' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Product' recordId="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a></td>" 
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

    </script>
@endsection