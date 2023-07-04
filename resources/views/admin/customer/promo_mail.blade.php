<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Promotion</title>

    <style>
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
    </style>
</head>


<body>
    <header class="clearfix">
        <div id="logo">
            <img src="https://i.postimg.cc/YSMVpR7D/kumo-logo.png" alt="logo" border="0" />
        </div>
        <div id="company">
            <h2 class="name">Kumo Store</h2>
            <div>455 Foggy Heights, AZ 85004, US</div>
            <div>(602) 519-0450</div>
            <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
        </div>
    </header>
</body>
<body>
    <div class="item" style="text-align: center">
        <h1>{{$header}}</h1>
    </div>
</body>
</html>
{!! $promo !!}



