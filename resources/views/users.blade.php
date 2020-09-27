@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/admin/banners')}} ">Users</a></li>
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
                                <h3 class="card-title">Categories</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addUserModalOpen()"> Add User</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="userTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                       
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addUserForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add User</h5>
                        <p class="errorMessage d-none"></p>
                        <div class="row" id="UserAddDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="browser-default custom-select" id="addUserRole" name="role">
                                        <option value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="addUserName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <input type="email" id="addUserEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="password" id="addUserPass" name="pass" class="form-control" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <input type="password" id="addUserConfPass" name="confPass" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="UserAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editUserForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit User</h5>
                        <h5 class="d-none" id="userId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="UserEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="browser-default custom-select" id="editUserRole" name="role">
                                        <option value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="editUserName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <input type="email" id="editUserEmail" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="UserEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getUser()
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // User add edit validation
        function valdation(addEditValidation) {
            $(addEditValidation).validate({
                rules: {
                    role: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    pass: {
                        required: true,
                        minlength: 6
                    },
                    confPass: {
                        required: true,
                        equalTo: '#addUserPass'
                    },
                },
                messages: {
                    role: {
                        required: "Please select user role",
                    },
                    name: {
                        required: "Please enter username",
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    pass: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    confPass: {
                        required: "Please retype your password",
                        equalTo: "Confirm password doesn't matched"
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
        }

        function getUser() {
            axios.get('/getUserData').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#userTable").DataTable().destroy();
                    $('#userTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].role + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + jsonData[i].email + "</td>" +
                            "<td><a id='editUser' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm'> <i class='far fa-edit'></i> </a> <a href='#' class='btn btn-danger btn-sm confirmDelete' record='User' recordId="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a></td>" 
                        ).appendTo('#userTableBody')
                    })
                } 

                $("#userTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }
        
        // User add modal open
        function addUserModalOpen() {
            $('#addUserModal').modal('show');
        }

        // User add confrim method
        $(document).on('click', '#UserAddConfirmBtn', function(e) {
            const role = $('#addUserRole').val();
            const name = $('#addUserName').val();
            const email = $('#addUserEmail').val();
            const pass = $('#addUserPass').val();
            const confPass = $('#addUserConfPass').val();
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            
            if(role == '' || name == '' || email == '' || pass == '' || confPass == '' || pass != confPass || !(pass.length >= 6) || !(email.match(emailPattern))) {
                valdation('#addUserForm');
            } else {
                e.preventDefault();
                $('#UserAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/addUser', {
                    role: role,
                    name: name,
                    email: email,
                    pass: pass,
                    confPass: confPass,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#UserAddConfirmBtn').text('Save').removeClass('disabled');
                        $('#addUserModal').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'User Added Successfully !'
                        });
                        getUser();
                    } else { 
                        $('#UserAddConfirmBtn').text('Save').removeClass('disabled');
                        Toast.fire({
                            icon: 'error',
                            title: 'Something Went Wrong !'
                        })
                    }
                }).catch((error) => {
                    $('#UserAddConfirmBtn').text('Save').removeClass('disabled');
                    Toast.fire({
                        icon: 'error',
                        title: error.message
                    })
                })  
            }
        });

        // User edit modal open
        $(document).on('click', '#editUser', function() {
            $('#editUserModal').modal('show');
            const id = $(this).data('id');
            $('#userId').text(id);
            getUserEditDetails(id)
        })

        // Get user details
        function getUserEditDetails(id) {
            axios.get('/getUserEditDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#UserEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editUserRole').val(response.data.role);
                    $('#editUserName').val(response.data.name);
                    $('#editUserEmail').val(response.data.email);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something Went Wrong !'
                    })
                }
            }).catch((error) => {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            })
        }

        // User edit confrim method
        $(document).on('click', '#UserEditConfirmBtn', function(e) {
            const id = $('#userId').text();
            const role = $('#editUserRole').val();
            const name = $('#editUserName').val();
            const email = $('#editUserEmail').val();
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            
            if(role == '' || name == '' || email == '' || !(email.match(emailPattern))) {
                valdation('#editUserForm');
            } else {
                e.preventDefault();
                $('#UserEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
                axios.post('/updateUserDetails', {
                    id: id,
                    role: role,
                    name: name,
                    email: email,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        Toast.fire({
                            icon: 'success',
                            title: 'User Updated Successfully.'
                        })
                        $('#editUserModal').modal('hide');
                        $('#UserEditConfirmBtn').text('Save').removeClass('disabled');
                        getUser();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something Went Wrong !'
                        });
                        $('#UserEditConfirmBtn').text('Save').removeClass('disabled');
                    }
                }).catch((error) => {
                    Toast.fire({
                        icon: 'error',
                        title: error.message
                    });
                    $('#UserEditConfirmBtn').text('Save').removeClass('disabled');
                });
            }
        });
    </script>   
@endsection