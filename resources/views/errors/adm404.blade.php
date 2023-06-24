@extends('layouts.dashboard')   



@section('content')
<html>
<style>
    .page_404 {
        padding: 40px 0;
        background: #fff;
        /* font-family: 'Arvo', serif; */
        text-align: center;
    }

    .page_404 img {
        width: 100%;
    }

    .four_zero_four_bg {

        background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
        height: 440px;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center" style="font-size: 70px">404</h1>
                        </div>
    
                        <div class="contant_box_404">
                            <h3 class="h2">
                                Look like you're lost
                            </h3>
    
                            <p>the page you are looking for not avaible!</p>
    
                            <a href="{{route('home')}}" class="btn btn-primary">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>


@endsection