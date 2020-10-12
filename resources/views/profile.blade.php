@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/profile')}} ">Profile</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="row">
                        <div class="card card-primary card-outline col-md-4 offset-md-4">
                            <div class="card-body box-profile">
                                <div class="loading text-center">
                                    <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                                </div>
                                <!-- Other contents from function-->

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <!-- /.card-body -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="editProfileForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Profile</h5>
                        <h5 class="d-none" id="profileId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="profileEditDetails">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="editProfileName" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="editProfileAddress" name="address" class="form-control" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="image">Profile Picture</label>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4">
                                            <img class="profileImage" id="profilePicture" src="" alt="Profile Image"/>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn btn-info btn-sm" type="button"><input type="file" id="editProfileImage" name="image" class="proPicSelect">Select Picture</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="editProfileEmail" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="editProfileNumber" name="mobile" class="form-control" placeholder="Contact Number">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Select Gender</label>
                                    <select class="browser-default custom-select" id="editProfileGender" name="gender">
                                        <option value="">Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="profileEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getProfileData();

        function getProfileData() {
            axios.get('/getProfileData').then((response) => {
                $('.box-profile').empty();
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const data = response.data;

                    $('<div>').html(
                        "<div class='text-center'><img class='profileImage' src='images/userImages/" + data.image + "' alt='Profile profile picture'> </div>" +
                        "<h4 class='profile-Profilename text-center mt-2'>" + data.name + "</h4>" +
                        "<p class='text-muted text-center'>" + data.role + "</p>" +

                        "<ul class='list-group list-group-unbordered mb-3'> <li class='list-group-item'> <b>Email</b> <a class='float-right'>" + data.email + "</a> </li> <li class='list-group-item'> <b>Address</b> <a class='float-right'>" + data.address + "</a> </li> <li class='list-group-item'> <b>Mobile</b> <a class='float-right'>" + data.mobile + "</a> </li> <li class='list-group-item'> <b>Gender</b> <a class='float-right'>" + data.gender + "</a> </li> </ul>" +

                        "<a href='#' id='editProfile' title='Edit Profile' data-id=" + data.id + " class='btn btn-primary btn-block btn-sm'><b>Edit Profile</b></a>"
                    ).appendTo('.box-profile')
                }

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        $(document).on('click', '#editProfile', function() {
            $('#editProfileModal').modal('show');
            const id = $(this).data('id');
            getProfileEditDetails(id);
        })

        function getProfileEditDetails(id) {
            axios.get('/getProfileEditDetails').then((response) => {
                if(response.status == 200) {
                    $('#profileEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editProfileRole').val(response.data.role);
                    $('#editProfileGender').val(response.data.gender);
                    $('#editProfileName').val(response.data.name);
                    $('#editProfileEmail').val(response.data.email);
                    $('#editProfileAddress').val(response.data.address);
                    $('#editProfileNumber').val(response.data.mobile);
                    $("#profilePicture").attr('src','images/userImages/'+response.data.image);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        $(document).on('change', '#editProfileImage', function(e) {
            $('#profilePicture').attr('src', '');
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function(e) {
                $('#profilePicture').attr('src', e.target.result);
            }
        });


        $(document).on('submit', '#editProfileForm', function(e) {
            const name = $('#editProfileName').val()
            const email = $('#editProfileEmail').val()
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

            const validationRules = Object.assign({
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
            });

            const validationMessage = Object.assign({
                    name: {
                        required: "You must enter your name !",
                    },
                    email: {
                        required: "You must enter your email address",
                        email: "Please enter a vaild email address"
                    },
            });

            if(name == '' || email == '' || !(email.match(emailPattern))) {
                validation('#editProfileForm', validationRules, validationMessage);
                e.preventDefault();
            } else {
                e.preventDefault();
                $('#profileEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
                const data = new FormData(this);

                axios.post('/updateProfileInfo', data).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#editProfileModal').modal('hide');
                        $('#profileEditConfirmBtn').text('Update').removeClass('disabled');
                        successMessage('Profile Updated Successfully.')
                        getProfileData();
                    } else {
                        $('#profileEditConfirmBtn').text('Update').removeClass('disabled');
                        $('#editProfileModal').modal('hide');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#profileEditConfirmBtn').text('Update').removeClass('disabled');
                    $('#editProfileModal').modal('hide');
                    errorMessage('Something Went Wrong !')
                });
            }
        });
    </script>
@endsection
