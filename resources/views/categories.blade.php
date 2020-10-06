@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/categories')}} ">Categories</a></li>
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
                                <h3 class="card-title">Manage Categories</h3>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right" onclick="addCategoryModalOpen()"> Add Category</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categoryTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoryTableBody">
                                       
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="addCategoryForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Add Category</h5>
                        <p class="errorMessage d-none"></p>
                        <div class="row" id="categoryAddDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="addCategoryName" name="name" class="form-control" placeholder="Category Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="categoryAddConfirmBtn" type="submit" class="btn btn-danger btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="editCategoryForm">
                    <div class="modal-body p-4">
                        <h5 class="text-center mb-4">Edit Category</h5>
                        <h5 class="d-none" id="categoryId"></h5>
                        <div class="loadingEdit text-center">
                            <img src="{{ asset('images/loading.svg') }}" alt="loading .."/>
                        </div>
                        <div class="row d-none" id="categoryEditDetails">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Category Name</label>
                                    <input type="text" id="editCategoryName" name="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                        <button id="categoryEditConfirmBtn" data-id="" type="submit" class="btn btn-danger btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        getCategories();

        // Get Categories
        function getCategories() {
            axios.get('/getCategories').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#categoryTable").DataTable().destroy();
                    $('#categoryTableBody').empty();

                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + jsonData[i].id + "</td>" +
                            "<td>" + jsonData[i].name + "</td>" +
                            "<td><a href='#' id='editCategory' title='Edit Category' data-id=" + jsonData[i].id + " class='btn btn-primary btn-sm actionBtn'> <i class='far fa-edit'></i> </a> " + ((jsonData[i].products.length == 0) ? ("<a href='#' title='Delete Category' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Category' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a>") : '') + " </td>" 
                        ).appendTo('#categoryTableBody')
                    })
                } 

                $("#categoryTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": false,
                });

            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Add Category Modal Open
        function addCategoryModalOpen() {
            $('#addCategoryModal').modal('show');
        }

        // Category and edit validation rules and messages
        const validationRules = Object.assign({
                name: {
                    required: true,
                },
        });

        const validationMsg = Object.assign({
                name: {
                    required: "Please enter Category name",
                },
        });

        // Add Category
        $(document).on('click', '#categoryAddConfirmBtn', function(e) {
            const name = $('#addCategoryName').val();
            
            if(name == '') {
                validation('#addCategoryForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#categoryAddConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');

                axios.post('/addCategory', {
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        $('#categoryAddConfirmBtn').text('Save').removeClass('disabled');
                        $('#addCategoryModal').modal('hide');
                        successMessage('Category Added Successfully.')
                        getCategories();
                    } else { 
                        $('#categoryAddConfirmBtn').text('Save').removeClass('disabled');
                        errorMessage('Something Went Wrong !')
                    }
                }).catch((error) => {
                    $('#categoryAddConfirmBtn').text('Save').removeClass('disabled');
                    errorMessage('Something Went Wrong !')
                })  
            }
        });

        // Edit Category Modal Open
        $(document).on('click', '#editCategory', function(e) {
            $('#editCategoryModal').modal('show');
            const id = $(this).data('id');
            getCategoryDetails(id);
        });

        // Get Category details
        function getCategoryDetails(id) {
            axios.get('/getCategoryDetails/'+id).then((response) => {
                if(response.status == 200) {
                    $('#categoryEditDetails').removeClass('d-none');
                    $('.loadingEdit').addClass('d-none');

                    $('#editCategoryName').val(response.data.name);
                    $('#categoryEditConfirmBtn').data('id', id);
                } else {
                    errorMessage('Something Went Wrong !')
                }
            }).catch((error) => {
                errorMessage('Something Went Wrong !')
            })
        }

        // Category Edit Confirm Method
        $(document).on('click', '#categoryEditConfirmBtn', function(e) {
            const id = $(this).data('id');
            const name = $('#editCategoryName').val();
            
            if(name == '') {
                validation('#editCategoryForm', validationRules, validationMsg);
            } else {
                e.preventDefault();
                $('#categoryEditConfirmBtn').html('<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Working...').addClass('disabled');
                axios.post('/updateCategoryDetails', {
                    id: id,
                    name: name,
                }).then((response) => {
                    if(response.status == 200 && response.data == 1) {
                        successMessage('Category Updated Successfully.')
                        $('#editCategoryModal').modal('hide');
                        $('#categoryEditConfirmBtn').text('Update').removeClass('disabled');
                        getCategories();
                    } else {
                        errorMessage('Something Went Wrong !')
                        $('#categoryEditConfirmBtn').text('Update').removeClass('disabled');
                    }
                }).catch((error) => {
                    errorMessage('Something Went Wrong !')
                    $('#categoryEditConfirmBtn').text('Update').removeClass('disabled');
                });
            }
        });
    </script>
@endsection