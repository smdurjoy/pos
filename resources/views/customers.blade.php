@extends('layouts.app')

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
                            <li class="breadcrumb-item active"><a href=" {{url('/customers')}} ">Customers</a></li>
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
                                <h3 class="card-title">Manage Customers</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addCustomerModalOpen()"> Add Customer</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="customerTable" class="table table-bordered table-sm">
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
                                    <tbody id="customerTableBody">

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

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addCustomerForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add Customer</h5>
                        <p class="errorMessage d-none"></p>
                        <div class="row" id="customerAddDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="addCustomerName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="addCustomerNumber" name="number" class="form-control" placeholder="Number">
                                </div>

                                <div class="form-group">
                                    <input type="email" id="addCustomerEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="addCustomerAddress" name="address" class="form-control" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="customerAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editCustomerForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Customer</h5>
                        <h5 class="d-none" id="CustomerId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="customerEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Customer Name</label>
                                    <input type="text" id="editCustomerName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="number">Number</label>
                                    <input type="text" id="editCustomerNumber" name="number" class="form-control" placeholder="Number">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="editCustomerEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="editCustomerAddress" name="address" class="form-control" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="customerEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getCustomers();

        // Get Customers
        function getCustomers() {
            axios.get('/getCustomers').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    console.log(jsonData);
                    $("#customerTable").DataTable().destroy();
                    $('#customerTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + ((jsonData[i].email == null) ? "Not Given" : jsonData[i].email) + "</td>" +
                            "<td>" + jsonData[i].number + "</td>" +
                            "<td>" + jsonData[i].address + "</td>" +
                            "<td><a href='#' id='editCustomer' title='Edit Customer' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a>" + ((jsonData[i].payments.length == 0) ? ("<a href='javascript:void(0)' title='Delete Customer' class='btn btn-danger btn-sm confirmDelete actionBtn ml-1' record='Customer' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a>") : ("<button type='button' class='btn btn-danger btn-sm actionBtn' disabled><i class='far fa-trash-alt deleteButton'></i></button>")) + " </td>"
                        ).appendTo('#customerTableBody')
                    })
                }

                $("#customerTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Add Customer Modal Open
        function addCustomerModalOpen() {
            $('#addCustomerModal').modal('show');
        }

        // Customer and edit validation rules and messages
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
            });

        const validationMsg = Object.assign({
                name: {
                    required: "Please enter Customer name",
                },
                number: {
                    required: "Please enter Customer number",
                },
                address: {
                    required: "Please enter Customer address",
                },
        });
        validation('#addCustomerForm', validationRules, validationMsg);

        // Add Customer
        $(document).on('submit', '#addCustomerForm', function(e) {
            e.preventDefault();
            $('#customerAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
            const data = new FormData(this);
            axios.post('/addCustomer', data).then((response) => {
                if(response.status == 200 && response.data == 1) {
                    $('#customerAddConfirmBtn').text('Save').removeClass('disabled');
                    $('#addCustomerModal').modal('hide');
                    successMessage('Customer Added Successfully.')
                    getCustomers();
                } else if(response.status == 200 && response.data == 2) {
                    $('#customerAddConfirmBtn').text('Save').removeClass('disabled');
                    warningMessage('Email address already exists !')
                }
                else {
                    $('#customerAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                $('#customerAddConfirmBtn').text('Save').removeClass('disabled');
                errorMessage('Something Went Wrong !')
            })
        });

        // Edit Customer Modal Open
        $(document).on('click', '#editCustomer', function(e) {
            $('#editCustomerModal').modal('show');
            const id = $(this).data('id');
            getCustomerDetails(id);
        });

        // Get Customer details
        function getCustomerDetails(id) {
            axios.get('/getCustomerDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#customerEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editCustomerName').val(response.data.name);
                    $('#editCustomerNumber').val(response.data.number);
                    $('#editCustomerEmail').val(response.data.email);
                    $('#editCustomerAddress').val(response.data.address);
                    $('#customerEditConfirmBtn').data('id', id);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Customer Edit Confirm Method
        $(document).on('click', '#customerEditConfirmBtn', function(e) {
            const id = $(this).data('id');
            const name = $('#editCustomerName').val();
            const number = $('#editCustomerNumber').val();
            const email = $('#editCustomerEmail').val();
            const address = $('#editCustomerAddress').val();
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

            if(name == '' || number == '' || address == '' || !(email.match(emailPattern))) {
                validation('#editCustomerForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#customerEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
                axios.post('/updateCustomerDetails', {
                    id: id,
                    name: name,
                    number: number,
                    address: address,
                    email: email,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        successMessage('Customer Updated Successfully.')
                        $('#editCustomerModal').modal('hide');
                        $('#customerEditConfirmBtn').text('Update').removeClass('disabled');
                        getCustomers();
                    } else {
                        errorMessage('Something Went Wrong !')
                        $('#customerEditConfirmBtn').text('Update').removeClass('disabled');
                    }
                }).catch((error) => {
                    errorMessage('Something Went Wrong !')
                    $('#customerEditConfirmBtn').text('Update').removeClass('disabled');
                });
            }
        });
    </script>
@endsection
