@extends('layouts.app')
@section('title', 'Pending Purchase')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Purchase</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href=" {{url('/pending-purchase')}} ">Pending Purchase</a></li>
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
                                <h3 class="card-title">Pending Purchase</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="purchaseTable" class="table table-bordered table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-bold">SL.</th>
                                            <th class="text-bold">Purchase No</th>
                                            <th class="text-bold">Date</th>
                                            <th class="text-bold">Supplier</th>
                                            <th class="text-bold">Category</th>
                                            <th class="text-bold">Product Name</th>
                                            <th class="text-bold">Quantity</th>
                                            <th class="text-bold">Unit Price</th>
                                            <th class="text-bold">Buying Price</th>
                                            <th class="text-bold">Status</th>
                                            <th class="text-bold">Description</th>
                                            <th class="text-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchaseTableBody">

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
        getPurchase();

        // Get Purchase
        function getPurchase() {
            axios.get('/pendingPurchaseList').then((response) => {
                if(response.status == 200) {
                    $('.loading').addClass('d-none');
                    const jsonData = response.data;
                    console.log(jsonData);
                    $("#purchaseTable").DataTable().destroy();
                    $('#purchaseTableBody').empty();

                    let index = 1;
                    $.each(jsonData, function (i) {
                        const date = jsonData[i].date;
                        const newDateFormat = date.split("-").reverse().join("-");
                        $('<tr>').html(
                            "<td>" + index++ + "</td>" +
                            "<td>" + jsonData[i].purchase_number + "</td>" +
                            "<td>" + newDateFormat + "</td>" +
                            "<td>" + jsonData[i].supplier.name + "</td>" +
                            "<td>" + jsonData[i].category.name + "</td>" +
                            "<td>" + jsonData[i].product.name + "</td>" +
                            "<td>" + jsonData[i].buying_quantity + ' ' + jsonData[i].product.unit.name + "</td>" +
                            "<td>" + jsonData[i].unit_price + " Tk</td>" +
                            "<td>" + jsonData[i].buying_price + " Tk</td>" +
                            "<td>" + ((jsonData[i].status == 0) ? ("<span class='badge badge-danger'>Pending</span>") : ("<span class='badge badge-success'>Approved</span>")) + "</td>" +
                            "<td>" + ((jsonData[i].description == null) ? '' : jsonData[i].description) + "</td>" +
                            "<td>"+ ((jsonData[i].status == 1) ? '' : ("<button href='#' title='Approve Purchase' class='btn btn-success btn-sm actionBtn updateStatus' record='Purchase' data-id="+ jsonData[i].id +"> <i class='fa fa-check-circle'></i> </button>")) + " </td>"
                        ).appendTo('#purchaseTableBody')
                    })
                }

                $("#purchaseTable").DataTable({
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
