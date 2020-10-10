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
            @yield('content')
            @php
                $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
            @endphp
        </div>
    </div>

    @yield('bottom-content')
    <div style="margin-top: 5px; font-size: 14px">
        <i>Printing time: {{ $date->format('F j, Y, g:i a') }}</i>
    </div>
</div>
</body>
</html>
