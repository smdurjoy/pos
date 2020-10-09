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
                <h5 class="title"><u>Sales Invoice</u></h5>
                <table class="table table-bordered">
                    <tr>
                        <td><span style="font-weight: bold;">Customer:</span> {{ $payment['customer']['name'] }}</td>
                        <td><span style="font-weight: bold;">Invoice No:</span> #{{ $invoice_no }}</td>
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;">Mobile:</span> {{ $payment['customer']['number'] }}</td>
                        <td><span style="font-weight: bold;">Date:</span> {{ date('d-m-Y', strtotime($date)) }} </td>
                    </tr>
                    <tr>
                        <td><span style="font-weight: bold;">Address:</span> {{ $payment['customer']['address'] }}</td>
                    </tr>
                </table>
                <table width="100%" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $total_amount = '0';
                        @endphp
                        @foreach($invoice_details as $key => $details)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $details['category']['name'] }}</td>
                                <td>{{ $details['product']['name'] }}</td>
                                <td>{{ $details['selling_quantity'] }}</td>
                                <td>{{ $details['unit_price'] }}</td>
                                <td>{{ $details['selling_price'] }}</td>
                            </tr>
                            @php
                                $total_amount += $details['selling_price'];
                            @endphp
                        @endforeach

                        <tr><td colspan="6"></td></tr><tr><td colspan="6"></td></tr>

                        <tr>
                            <td colspan="5"><span style="font-weight: bold;">Total Amount</span></td>
                            <td><span style="font-weight: bold;">{{ $total_amount }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="5">Less Discount</td>
                            <td>{{ $payment['discount_amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="5">Paid Amount</td>
                            <td>{{ $payment['paid_amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="5">Due Amount</td>
                            <td>{{ $payment['due_amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="5"><span style="font-weight: bold;">Net Payable Amount</span></td>
                            <td><span style="font-weight: bold;">{{ $payment['total_amount'] }}</span></td>
                        </tr>
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
                        <td style="width: 40%;">
                            <p style="text-align: center; margin-left: 20px">Customer Signature</p>
                        </td>
                        <td style="width: 20%"></td>
                        <td style="width: 40%; text-align: right">
                            <p style="text-align: right">Seller Signature</p>
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
