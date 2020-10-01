@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Units</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/units')}} ">Units</a></li>
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
                                <h3 class="card-title">View Units</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addUnitModalOpen()"> Add Unit</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="unitTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="unitTableBody">
                                       
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

    <!-- Add Unit Modal -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addUnitForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add Unit</h5>
                        <p class="errorMessage d-none"></p>
                        <div class="row" id="unitAddDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="addUnitName" name="name" class="form-control" placeholder="Unit Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="unitAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Unit Modal -->
    <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editUnitForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Unit</h5>
                        <h5 class="d-none" id="unitId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="unitEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Unit Name</label>
                                    <input type="text" id="editUnitName" name="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="unitEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getUnits();

        // Get Units
        function getUnits() {
            axios.get('/getUnits').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#unitTable").DataTable().destroy();
                    $('#unitTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td><a href='#' id='editUnit' title='Edit Unit' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> <a href='#' title='Delete Unit' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Unit' recordId="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a></td>" 
                        ).appendTo('#unitTableBody')
                    })
                } 

                $("#unitTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Add Unit Modal Open
        function addUnitModalOpen() {
            $('#addUnitModal').modal('show');
        }

        // Unit and edit validation rules and messages
        const validationRules = Object.assign({
                name: {
                    required: true,
                },
        });

        const validationMsg = Object.assign({
                name: {
                    required: "Please enter Unit name",
                },
        });

        // Add Unit
        $(document).on('click', '#unitAddConfirmBtn', function(e) {
            const name = $('#addUnitName').val();
            
            if(name == '') {
                validation('#addUnitForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#unitAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/addUnit', {
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#unitAddConfirmBtn').text('Save').removeClass('disabled');
                        $('#addUnitModal').modal('hide');
                        successMessage('Unit Added Successfully.')
                        getUnits();
                    } else { 
                        $('#unitAddConfirmBtn').text('Save').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#unitAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                })  
            }
        });

        // Edit Unit Modal Open
        $(document).on('click', '#editUnit', function(e) {
            $('#editUnitModal').modal('show');
            const id = $(this).data('id');
            getUnitDetails(id);
        });

        // Get Unit details
        function getUnitDetails(id) {
            axios.get('/getUnitDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#unitEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editUnitName').val(response.data.name);
                    $('#unitEditConfirmBtn').data('id', id);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Unit Edit Confirm Method
        $(document).on('click', '#unitEditConfirmBtn', function(e) {
            const id = $(this).data('id');
            const name = $('#editUnitName').val();
            
            if(name == '') {
                validation('#editUnitForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#unitEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
                axios.post('/updateUnitDetails', {
                    id: id,
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        successMessage('Unit Updated Successfully.')
                        $('#editUnitModal').modal('hide');
                        $('#unitEditConfirmBtn').text('Update').removeClass('disabled');
                        getUnits();
                    } else {
                        errorMessage('Something Went Wrong !')
                        $('#unitEditConfirmBtn').text('Update').removeClass('disabled');
                    }
                }).catch((error) => {
                    errorMessage('Something Went Wrong !')
                    $('#unitEditConfirmBtn').text('Update').removeClass('disabled');
                });
            }
        });
    </script>
@endsection