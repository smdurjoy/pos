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
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <h5 class="text-center mb-4">Add User</h5>
                    <div class="row" id="UserAddDetails">
                        <div class="col-md-12">
                            <select class="browser-default custom-select mb-4" id="addUserRole">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                            <input type="text" id="addUserName" class="form-control mb-4" placeholder="Name">
                            <input type="email" id="addUserEmail" class="form-control mb-4" placeholder="Email">
                            <input type="password" id="addUserPass" class="form-control mb-4" placeholder="Password">
                            <input type="password" id="addUserConfPass" class="form-control mb-4" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                    <button id="UserAddConfirmBtn" type="button" class="btn btn-danger btn-sm">Save</button>
                </div>
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

        
        function getUser() {
            axios.get('/getUserData').then((response) => {

                if(response.status == 200) {
                    const jsonData = response.data;
                    $("#userTable").DataTable().destroy();
                    $('#userTableBody').empty();
                    console.log(jsonData)

                        $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].role + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td>" + jsonData[i].email + "</td>" +
                            "<td><a id='userId' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm'> <i class='far fa-edit'></i> </a> <a href='#' class='btn btn-danger btn-sm confirmDelete'> <i class='far fa-trash-alt deleteButton'></i> </a></td>" 
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

        $(document).on('click', '#userId', function() {
            const id = $(this).data('id');
            alert(id)
        })
        
        function addUserModalOpen() {
            $('#addUserModal').modal('show');
        }

        $(document).on('click', '#UserAddConfirmBtn', function() {
            const role = $('#addUserRole').val();
            const name = $('#addUserName').val();
            const email = $('#addUserEmail').val();
            const pass = $('#addUserPass').val();
            const confPass = $('#addUserConfPass').val();
            
            axios.post('/addUser', {
                role: role,
                name: name,
                email: email,
                pass: pass,
                confPass: confPass,
            }).then((response) => {
                if(response.status == 200 && response.data == 1) {
                    $('#addUserModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'User Added Successfully !'
                    });
                    getUser();
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
        })




    </script>   
@endsection