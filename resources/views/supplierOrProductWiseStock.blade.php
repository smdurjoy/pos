@extends('layouts.app')
@section('title', 'Stock Report')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('//stock-report-product-supplier-wise')}} ">Stock Report</a></li>
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
                                <h3 class="card-title">Select Criteria</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="searchValue" value="supplier_wise">
                                            <label class="form-check-label" for="supplierWise">Supplier Wise Report</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="searchValue" value="product_wise">
                                            <label class="form-check-label" for="productWise">Product Wise Report</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 supplierDropdown d-none">
                                        <form id="supplierReport" method="get" action="{{ url('/print/supplier-wise-stock') }}" target="_blank">
                                            <div class="form-group">
                                                <label for="supplier_name">Supplier</label>
                                                <select class="form-control select2" style="width: 100%;" name="supplier_id">
                                                    <option value="">Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier['id'] }}">{{ $supplier['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-dark btn-sm" type="submit">Search</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 productDropdown d-none">
                                        <form id="productReport" method="get" action="{{ url('/print/product-wise-stock') }}" target="_blank">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control select2" style="width: 100%;" name="category_id" id="category">
                                                    <option value="">Select Product Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Product</label>
                                                <select class="form-control select2" style="width: 100%;" name="product_id" id="product">
                                                    <option value="">Select Category First</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-dark btn-sm" type="submit">Search</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
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
        $(document).on('change', '#searchValue', function () {
            const searchValue = $(this).val();
            if(searchValue == 'supplier_wise') {
                $('.supplierDropdown').removeClass('d-none');
            } else {
                $('.supplierDropdown').addClass('d-none');
            }

            if(searchValue == 'product_wise') {
                $('.productDropdown').removeClass('d-none');
            } else {
                $('.productDropdown').addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#supplierReport').validate({
                ignore:[],
                errorPlacement: function (error, element) {
                    if(element.attr('name') == 'supplier_id'){ error.insertAfter(
                      element.next()); }
                    else{error.insertAfter(element);}
                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                rules: {
                    supplier_id : {
                        required: true,
                    },
                    category_id : {
                        required: true,
                    },
                    product_id : {
                        required: true,
                    },
                },
                messages : {
                    supplier_id: {
                        required: "Please Select Supplier",
                    },
                    category_id: {
                        required: "Please Select Category",
                    },
                    product_id: {
                        required: "Please Select Product",
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        $(document).ready(function () {
            $('#productReport').validate({
                ignore:[],
                errorPlacement: function (error, element) {
                    if(element.attr('name') == 'category_id', 'product_id'){ error.insertAfter(
                      element.next()); }
                    else{error.insertAfter(element);}
                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                rules: {
                    category_id : {
                        required: true,
                    },
                    product_id : {
                        required: true,
                    },
                },
                messages : {
                    category_id: {
                        required: "Please Select Category",
                    },
                    product_id: {
                        required: "Please Select Product",
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        // Get products on category select
        $(document).on('change', '#category', function() {
            const category_id = $('#category option:selected').val();

            axios.post('/getProducts', {category_id: category_id}).then((response) => {
                $('#product').empty();
                $('#product').append($('<option></option>').html('Loading ..'));

                if(response.status == 200) {
                    const data = response.data;

                    if(data.length < 1 ) {
                        $('#product').empty()
                        $('#product').append($('<option></option>').val("").html("No Products Available"))
                    } else {
                        $('#product').empty()
                        $('#product').append($('<option></option>').val("").html("Select Product"))
                        $.each(data, function (i) {
                            $('#product').append($('<option></option>').val(data[i].id).html(data[i].name))
                        });
                    }
                }

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        });
    </script>
@endsection
