<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .houseName {
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .address {
            font-size: 14px;
            text-transform: uppercase;
        }
        .houseInfo {
            margin-left: 3rem;
        }
        .houseDetails {
            margin-top: .5rem;
            margin-left: 3rem;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="houseInfo">
                <h4 class="houseName">Amar Store</h4>
                <h6 class="address">75/76 R & R TOWER 1st 2nd FLOOR STATION ROAD, RANGPUR </h6>
            </div>
            <div class="houseDetails">
                <table width="100%">
                    <tr>
                        <td>Mobile: 01881068188, 01646614411</td>
                        <td>Phone: 0521-52222</td>
                    </tr>
                    <tr>
                        <td>Email: info@amarstore.com</td>
                        <td>www.amarstore.com</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            <h5 class="title">Stock Report</h5>
            <table width="100%" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Supplier Name</th>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Unit</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($stocks as $key => $stock)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $stock['supplier']['name'] }}</td>
                            <td>{{ $stock['category']['name'] }}</td>
                            <td>{{ $stock['name'] }}</td>
                            <td>{{ $stock['quantity'] }}</td>
                            <td>{{ $stock['unit']['name'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php
                $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
            @endphp
        </div>
    </div>

    <div class="row" style="margin-top: 2.5rem">
        <div class="col-md-12">
            <hr style="margin-bottom: 0">
            <table style="width: 100%; border:0;">
                <tr>
                    <td style="width: 20%"></td>
                    <td style="width: 40%; text-align: right">
                        <p style="text-align: right">Owner Signature</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="margin-top: 5px; font-size: 14px">
        <i>Printing time: {{ $date->format('F j, Y, g:i a') }}</i>
    </div>
</div>
</body>
</html>
