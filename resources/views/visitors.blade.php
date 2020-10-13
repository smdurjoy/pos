@extends('layouts.app')
@section('title', 'Visitors')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Visitors</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/visitors')}} ">Visitors</a></li>
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
                                <h3 class="card-title">Visitors</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="visitorTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-bold">SL.</th>
                                        <th class="text-bold">Ip Address</th>
                                        <th class="text-bold">Visit Time</th>
                                        <th class="text-bold">Country</th>
                                        <th class="text-bold">Region</th>
                                        <th class="text-bold">City</th>
                                        <th class="text-bold">Zip Code</th>
                                        <th class="text-bold">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="visitorTableBody">

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
        getVisitors();

        // Get Visitors
        function getVisitors() {
            axios.get('/getVisitors').then((response) => {
                if(response.status == 200) {
                    console.log(response.data)
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    $("#visitorTable").DataTable().destroy();
                    $('#visitorTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].ipAddress + "</td>" +
                            "<td>" + jsonData[i].visitTime + "</td>" +
                            "<td>" + jsonData[i].countryName + "</td>" +
                            "<td>" + jsonData[i].regionName + "</td>" +
                            "<td>" + jsonData[i].cityName + "</td>" +
                            "<td>" + jsonData[i].zipCode + "</td>" +
                            "<td><a href='#' title='Delete Visitor' class='btn btn-danger btn-sm confirmDelete actionBtn' record='Visitor' data-id="+ jsonData[i].id +"> <i class='far fa-trash-alt deleteButton'></i> </a></td>"
                        ).appendTo('#visitorTableBody')
                    })
                }

                $("#visitorTable").DataTable({
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
