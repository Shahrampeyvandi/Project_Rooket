<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}

    <title> @yield('title' , 'صفحه اصلی')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">
                {{--video-js--}}
    <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

             {{--owl-carousel--}}
    <link href="/css/owl.carousel.min.css" rel="stylesheet">
    <link href="/css/owl.theme.default.min.css" rel="stylesheet">

{{--    <link href="/css/app.css" rel="stylesheet">--}}
    <link href="/css/home.css" rel="stylesheet">
    <link href="/css/slick.css" rel="stylesheet">
    <link href="/css/slick-theme.css" rel="stylesheet">

    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-rtl.min.css">
    <link href="/feed/articles" rel="alternate" title="فید مقالات" type="application/rss+xml">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
@yield('content')
<div class="container">
    <div class="row margin-top">
            @include('Home.tab')
            @include('Home.carousel')

    </div>
</div>

<!-- /.container -->

@include('Home.footer')
<!-- /.container -->

<script src="{{asset('js/app.js')}}"></script>
<script src="js/jquery.min.js"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="{{asset('js/personal.js')}}"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
