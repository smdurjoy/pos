@extends('layouts.app')
@section('title', 'Update Password')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/update-password')}} ">Update-Passowrd</a></li>
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
                                <h3 class="card-title">Change Password</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body col-md-8 offset-md-2">
                                <form id="updatePassForm">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="crntPass">Current Password</label>
                                            <input type="password" class="form-control" id="currentPass" placeholder="Enter Current Password" name="currentPass">
                                            <span id="checkCrntPass"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="newPass">New Password</label>
                                            <input type="password" class="form-control" id="newPass" name="newPass" placeholder="Enter New Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confNewPass">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Enter the same as New">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" id="updatePass" class="btn btn-primary btn-sm">Update</button>
                                    </div>
                                </form>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('keyup', '#currentPass', function () {
            const currentPass = $(this).val();

            axios.post('/checkCurrentPass', {currentPass:currentPass}).then((response) => {
                if(response.data == 1) {
                    $('#currentPass').addClass('rightPass');
                    $('#currentPass').removeClass('wrongPass');
                    $("#checkCrntPass").html("<font color='green'>Password is correct</font>");
                }
                else if(response.data == 0) {
                    $('#currentPass').removeClass('rightPass');
                    $('#currentPass').addClass('wrongPass');
                    $("#checkCrntPass").html("<font color='red'>Password is incorrect</font>");
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage(error.message)
            })
        });

        $(document).on('click', '#updatePass', function(e) {
            const validationRules = Object.assign({
                    currentPass: {
                        required: true,
                    },
                    newPass: {
                        required: true,
                        minlength: 6
                    },
                    confirmPass: {
                        required: true,
                        equalTo: '#newPass',
                    },
                });

            const validationMsg = Object.assign({
                    currentPass: {
                        required: "Please enter your current password",
                    },
                    newPass: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 6 characters long ",
                    },
                    confirmPass: {
                        required: "Please retype your password",
                        equalTo: "Password doesn't matched"
                    },
            });

            const currentPass = $('#currentPass').val();
            const newPass = $('#newPass').val();
            const confirmPass = $('#confirmPass').val();

            if(currentPass == '' || newPass == '' || confirmPass == '' || newPass != confirmPass || newPass <= 5) {
                validation('#updatePassForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $(this).html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/updatePass', {
                    currentPass: currentPass,
                    newPass: newPass,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $(this).text('Update').removeClass('disabled');
                        successMessage('Password Updated Successfully.')
                        $('#currentPass').val('');
                        $('#newPass').val('');
                        $('#confirmPass').val('');
                        $('#currentPass').removeClass('rightPass');
                        $('#currentPass').removeClass('wrongPass');
                        $("#checkCrntPass").html("");
                    } else {
                        $(this).text('Update').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                        $('#currentPass').val('');
                        $('#newPass').val('');
                        $('#confirmPass').val('');
                    }
                }).catch((error) => {
                    $(this).text('Update').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                    $('#currentPass').val('');
                    $('#newPass').val('');
                    $('#confirmPass').val('');
                })
            }
        });
    </script>
@endsection
