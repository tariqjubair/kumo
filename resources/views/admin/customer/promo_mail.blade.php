
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<head>
    <style>
        img {
            margin: 0 auto;
        }
        .link a {
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
        }
    </style>
</head>
<body style="margin: 30px;">
    <div class="item" style="text-align: center">
        <h1 style="margin-bottom: 30px; font-size: 40px;">
            {{$header}}
        </h1>
    </div>
{!! $promo !!}
    <div class="link" style="text-align: center">
        <a href="{{route('home_page')}}" target="_blank"
            style="background:#1A82E2;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Visit Kumo Store</a>
    </div>
</body>



