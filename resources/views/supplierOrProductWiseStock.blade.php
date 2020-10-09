@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/stocks')}} ">Stock Report</a></li>
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
                                <form id="pOrSReport" method="get" action="{{ url('/print/supplier-product-wise-stock') }}" target="_blank">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="searchValue" value="supplier_wise">
                                                <label class="form-check-label" for="inlineRadio1">Supplier Wise Report</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="searchValue" value="product_wise">
                                                <label class="form-check-label" for="inlineRadio2">Product Wise Report</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 supplierDropdown d-none">
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
                                        </div>
                                        <div class="col-md-6 productDropdown d-none">
                                            <div class="form-group">
                                                <label for="product_name">Supplier</label>
                                                <select class="form-control select2" style="width: 100%;" name="product_name">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-dark btn-sm" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
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
        });

        $(document).ready(function () {
            $('#pOrSReport').validate({
                ignore:[],
                errorPlacement: function (error, element) {
                    if(element.attr('name') == 'supplier_name'){ error.insertAfter(
                      element.next()); }
                    else{error.insertAfter(element);}
                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                rules: {
                    supplier_id : {
                        required: true,
                    }
                },
                messages : {
                    supplier_id: {
                        required: "Please Select Supplier",
                    }
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
        })
    </script>
@endsection
