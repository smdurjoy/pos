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
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm" style="float: right"> Add Supplier</a>
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
                            "<td>" + jsonData[i].email + "</td>" +
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
    </script>
@endsection