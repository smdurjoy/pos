@extends('layouts.app')
@section('title', 'Manage Suppliers')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Suppliers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/suppliers')}} ">Suppliers</a></li>
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
                                <h3 class="card-title">Manage Suppliers</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addSupplierModalOpen()"> Add Supplier</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="supplierTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">SL.</th>
                                            <th class="text-bold">Name</th>
                                            <th class="text-bold">Email</th>
                                            <th class="text-bold">Mobile</th>
                                            <th class="text-bold">Address</th>
                                            <th class="text-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="supplierTableBody">

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

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addSupplierForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add Supplier</h5>
                        <p class="errorMessage d-none"></p>
                        <div class="row" id="SupplierAddDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="addSupplierName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="addSupplierNumber" name="number" class="form-control" placeholder="Number">
                                </div>

                                <div class="form-group">
                                    <input type="email" id="addSupplierEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="addSupplierAddress" name="address" class="form-control" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="supplierAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editSupplierForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Supplier</h5>
                        <h5 class="d-none" id="supplierId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="supplierEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Supplier Name</label>
                                    <input type="text" id="editSupplierName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="number">Number</label>
                                    <input type="text" id="editSupplierNumber" name="number" class="form-control" placeholder="Number">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="editSupplierEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="editSupplierAddress" name="address" class="form-control" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="supplierEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getSuppliers();

        // Get Suppliers
        function getSuppliers() {
            axios.get('/getSuppliers').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#supplierTable").DataTable().destroy();
                    $('#supplierTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + ((jsonData[i].email == null) ? "Not Given" : jsonData[i].email) + "</td>" +
                            "<td>" + jsonData[i].number + "</td>" +
                            "<td>" + jsonData[i].address + "</td>" +
                            "<td><a href='#' id='editSupplier' title='Edit Supplier' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> " + ((jsonData[i].products.length == 0) ? ("<a href='#' title='Delete Supplier' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Supplier' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a>") : ("<button type='button' class='btn btn-danger btn-sm actionBtn disableBtn' disabled><i class='far fa-trash-alt deleteButton'></i></button>")) + "</td>"
                        ).appendTo('#supplierTableBody')
                    })
                }

                $("#supplierTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Add Supplier Modal Open
        function addSupplierModalOpen() {
            $('#addSupplierModal').modal('show');
        }

        // Supplier and edit validation rules and messages
        const validationRules = Object.assign({
                    name: {
                        required: true,
                    },
                    number: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    email: {
                        email: true,
                    },
            });

        const validationMsg = Object.assign({
                name: {
                    required: "Please enter supplier name",
                },
                number: {
                    required: "Please enter supplier number",
                },
                address: {
                    required: "Please enter supplier address",
                },
                email: {
                    email: "Please enter a valid email address",
                },
        });
        validation('#addSupplierForm', validationRules, validationMsg);

        // Add Supplier
        $(document).on('submit', '#addSupplierForm', function(e) {
            e.preventDefault();
            $('#supplierAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const data = new FormData(this);
            axios.post('/addSupplier', data).then((response) => {
                if(response.status == 200 && response.data == 1) {
                    $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                    $('#addSupplierModal').modal('hide');
                    successMessage('Supplier Added Successfully.')
                    $("#addSupplierForm").trigger("reset");
                    getSuppliers();
                } else {
                    $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                errorMessage('Something Went Wrong !')
            })
        });

        // Edit Supplier Modal Open
        $(document).on('click', '#editSupplier', function(e) {
            $('#editSupplierModal').modal('show');
            const id = $(this).data('id');
            getSupplierDetails(id);
        });

        // Get Supplier details
        function getSupplierDetails(id) {
            axios.get('/getSupplierDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#supplierEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editSupplierName').val(response.data.name);
                    $('#editSupplierNumber').val(response.data.number);
                    $('#editSupplierEmail').val(response.data.email);
                    $('#editSupplierAddress').val(response.data.address);
                    $('#supplierEditConfirmBtn').data('id', id);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }
        validation('#editSupplierForm', validationRules, validationMsg);

        // Supplier Edit Confirm Method
        $(document).on('submit', '#editSupplierForm', function(e) {
            e.preventDefault();
            const id = $('#supplierEditConfirmBtn').data('id');
            const data = new FormData(this);
            data.append('id', id);
            $('#supplierEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            axios.post('/updateSupplierDetails', data).then((response) => {
                if(response.status == 200 && response.data == 1) {
                    successMessage('Supplier Updated Successfully.')
                    $('#editSupplierModal').modal('hide');
                    $('#supplierEditConfirmBtn').text('Update').removeClass('disabled');
                    getSuppliers();
                } else {
                    errorMessage('Something Went Wrong !')
                    $('#supplierEditConfirmBtn').text('Update').removeClass('disabled');
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
                $('#supplierEditConfirmBtn').text('Update').removeClass('disabled');
            });
        });
    </script>
@endsection
