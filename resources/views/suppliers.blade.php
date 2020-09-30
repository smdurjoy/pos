@extends('layouts.app')

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
                                <h3 class="card-title">View Suppliers</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addSupplierModalOpen()"> Add Supplier</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="supplierTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>Action</th>
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
@endsection

@section('script')
    <script type="text/javascript">
        getSuppliers();

        function getSuppliers() {
            axios.get('/getSuppliers').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#supplierTable").DataTable().destroy();
                    $('#supplierTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + ((jsonData[i].email == null) ? "Not Given" : jsonData[i].email) + "</td>" +
                            "<td>" + jsonData[i].number + "</td>" +
                            "<td>" + jsonData[i].address + "</td>" +
                            "<td><a href='#' id='editSupplier' title='Edit Supplier' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> <a href='#' title='Delete Supplier' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Supplier' recordId="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a></td>" 
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

        function addSupplierModalOpen() {
            $('#addSupplierModal').modal('show');
        }

        $(document).on('click', '#supplierAddConfirmBtn', function(e) {
            const supplierName = $('#addSupplierName').val();
            const supplierNumber = $('#addSupplierNumber').val();
            const supplierEmail = $('#addSupplierEmail').val();
            const supplierAddress = $('#addSupplierAddress').val();
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

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
            
            if(supplierName == '' || supplierNumber == '' || supplierAddress == '' || !(supplierEmail.match(emailPattern))) {
                validation('#addSupplierForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#supplierAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/addSupplier', {
                    name: supplierName,
                    number: supplierNumber,
                    email: supplierEmail,
                    address: supplierAddress,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                        $('#addSupplierModal').modal('hide');
                        successMessage('Supplier Added Successfully.')
                        getSuppliers();
                    } else { 
                        $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#supplierAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                })  
            }
        });

    </script>
@endsection