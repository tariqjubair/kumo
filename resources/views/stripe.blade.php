
<html>
    <head>
        <title>Kumo</title>
	    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/site_logo.png')}}">
    </head>
    <body style="text-align:center;">
        <div class="item" style="padding-top: 10%">
            <a href="https://stripe.com/">
                <img src="{{asset('assets/img/stripe_img.png')}}" width="30%" alt="Stripe">
            </a>
        </div>
    </body>
</html>

<form action="{{route('stripe.post')}}" method="POST">
    @csrf

    @php
        $amount = session('gtotal') * 100;
    @endphp

    <script
        src="https://checkout.stripe.com/checkout.js"
        class="stripe-button"
        data-label="Make Payment with Stripe"
        data-key="pk_test_51MaiEGAmT26OJ1aXiWlV4R5onfNvWE7urZetkYiqfq7ZGAr2B2VfRdyibPJPDgrvj9Sk3zXcxngdb9EIqJjh45fl007HmYw1hS"
        
        data-name="Kumo Store"
        data-description="Payment for Order: {{session('order_id')}}"

        data-amount="{{$amount}}"
        data-image="{{asset('assets/img/site_logo.png')}}"
        data-currency="bdt">
    </script>
</form>