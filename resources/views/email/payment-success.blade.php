<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 40px 40px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-details {
            margin-bottom: 15px;
        }
        .logo {
            max-width: 200px;
            margin: 0 auto;
        }
        .invoice-section {
            background-color: #f0f2f5;
            margin-bottom: 20px;
            padding: 30px 40px;
        }
        .last-padd{
            padding: 20px 40px;
        }
        .invoice-section h4 {
            margin-bottom: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: none; /* Remove border around the table */
        }
        .items-table th,
        .items-table td {
            padding: 5px;
            border: none; /* Remove borders around table cells */
        }
        .no-padding th,
        .no-padding td {
            padding: 5px;
            border: none; /* Remove borders around table cells */
        }
        .invoice-total {
            margin-top: 20px;
            text-align: right;
        }
        .invoice-total p {
            margin-bottom: 5px;
        }
        .basic-info , .details{
            display: flex;
        }
        .basic-info > * {
            flex-basis: calc(50% - 10px); /* Adjust the width as needed */
            margin-right: 10px;
            margin-bottom: 10px;
        }
        h5{
            text-transform:uppercase;
        }
        .border-none{
            border: none;
        }
        .items{
            border-bottom: 2px solid gray;
        }
    </style>
</head>
<body>
    <div class="basic-container">
        <div class="logo">
            {{-- <img alt="" border="0" src="{{ public_path('images/logo.svg') }}" style="max-width:200px;height:auto;display:block;color: #000000;" width="600"> --}}
        </div
        <div class="last-padd">
            <h1>Receipt</h1>
            <div class="basic-info">
                <table class="border-none items-table ">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h5 ><span style="color:#5f7078;margin-bottom:0px">Payment Id: </span>{{ $payment_details->stripe_id }}</h5>
                                <h5 ><span style="color:#5f7078;margin-bottom:0px">Paid Date: </span>{{ $payment_details->started_at }}</h5>
                                <h5 ><span style="color:#5f7078;margin-bottom:0px">Payment Method: </span>{{ $payment_details->card }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 ><span style="color:#5f7078;margin-bottom:0px">{{env('APP_NAME')}}</h5>
                                <h5 ><span style="vertical-align:middle">Krak. Przedm. 16/18 POLAND</span></h5>
                                <h5 ><span style="vertical-align:middle">+48 888 185 114</span></h5>
                                <h5 ><span style="vertical-align:middle"><span style="vertical-align:middle">contact@neuronus.net</span></span></h5>
                            </td>
                            <td style='vertical-align:top'>
                                <h5 ><span  style="color:#5f7078;margin-bottom:0px">TO</span></h5>
                                <h5 >{{ $user->name }}</h5>
                                <h5 >{{ $user->email }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 ><span  style="color:#5f7078;margin-bottom:0px">Description</span></h5>
                                <h3>Subscribed to {{$payment_details->plan_name}}, {{$payment_details->currency== 'usd' ? '$' : $payment_details->currency }}{{$payment_details->amount}} paid on {{  $payment_details->started_at}}.</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
