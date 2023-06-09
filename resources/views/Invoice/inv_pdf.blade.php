<!DOCTYPE html>
<html lang="en">

@php
$order_info = App\Models\OrderTab::where('order_id', $order_id)->first();
$billing_info = App\Models\BillingTab::where('order_id', $order_id)->first();
$ord_product = App\Models\OrdereditemsTab::where('order_id', $order_id)->first();
@endphp

<head>
    <meta charset="utf-8">
    <title>Invoice {{$order_id}}</title>
    <!-- <link rel="stylesheet" href="style.css" media="all" /> -->

    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            /* width: 21cm; */
            width: 100%;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            float: left;
        }

        #client .item {
            padding-left: 6px;
            border-left: 6px solid #EE1C47;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {}

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #EE1C47;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="https://i.postimg.cc/YSMVpR7D/kumo-logo.png" alt="logo" border="0" />
        </div>
        <div id="company">
            <h2 class="name">{{$site_info->site_name}}</h2>
            <div>{{$site_info->site_add1}}, {{$site_info->site_add2}}</div>
            <div>({{$site_info->site_ph_code}}) {{$site_info->site_phone}}</div>
            <div><a href="mailto:{{$site_info->site_email}}">{{$site_info->site_email}}</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="item" style="margin-bottom: 8px">
                    <div class="to">INVOICE TO:</div>
                    <h2 class="name">{{$billing_info->relto_cust->name}}</h2>
                    <div class="email"><a href="mailto:{{$billing_info->relto_cust->email}}">{{$billing_info->relto_cust->email}}</a></div>
                </div>

                <div class="item">
                    <div class="to">DELIVERY ADDRESS:</div>
                    <h2 class="name">{{$billing_info->name}}</h2>
                    <div class="address">Phone: <a href="tel:{{$billing_info->mobile}}">{{$billing_info->mobile}}</div>
                    <div class="address">Address: {{$billing_info->address}}</div>
                    <div class="address">{{$billing_info->relto_city->name.', '.$billing_info->relto_country->name.' - '.$billing_info->zip.'.'}}</div>
                    <div class="email">Email: <a href="mailto:{{$billing_info->email}}">{{$billing_info->email}}</a></div>
                </div>
            </div>
            <div id="invoice">
                <h1>INVOICE</h1>
                <div class="date">Order ID: {{$order_id}}</div>
                <div class="date">Date of Invoice: {{$billing_info->created_at->format('d-M-y')}}</div>
                <div class="date">Due Date: {{$billing_info->created_at->addDays(7)->format('d-M-y')}}</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">DESCRIPTION</th>
                    <th class="unit">UNIT PRICE</th>
                    <th class="qty">QUANTITY</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Models\OrdereditemsTab::where('order_id', $order_id)->get() as $sl=>$product)
                    <tr>
                        <td class="no">{{$sl + 1}}</td>
                        <td class="desc">
                            <h3>{{$ord_product->relto_product->product_name}}</h3>
                            {{$ord_product->relto_product->short_desc}}
                        </td>
                        <td class="unit">{{number_format(round($product->price), 2)}}</td>
                        <td class="qty">{{$product->quantity}}</td>
                        <td class="total">{{number_format(round($product->price * $product->quantity), 2)}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>{{number_format(round($order_info->total), 2)}} Tk.</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">DISCOUNT</td>
                    <td>{{number_format(round($order_info->discount), 2)}} Tk.</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">DELIVERY CHARGES</td>
                    <td>{{number_format(round($order_info->charge), 2)}} Tk.</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">GRAND TOTAL</td>
                    <td>{{number_format(round($order_info->gtotal), 2)}} Tk.</td>
                </tr>
            </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
        <div id="notices">
            <div>Payment: 
                @if ($order_info->payment_method == 1)
                    {{'Cash on Delivery'}}
                @elseif ($order_info->payment_method == 2)
                    {{'Paid with SSLCommerz'}}
                @elseif ($order_info->payment_method == 3)
                    {{'Paid with Stripe'}}
                @endif
            </div>
            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>
