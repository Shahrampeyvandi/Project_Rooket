<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}

    <title> @yield('title' , 'صفحه اصلی')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/imagehover.min.css">

    <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <link href="/css/owl.carousel.min.css" rel="stylesheet">
    <link href="/css/owl.theme.default.min.css" rel="stylesheet">

{{--    <link href="/css/app.css" rel="stylesheet">--}}
    <link href="/css/home.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-rtl.min.css">
    <link href="/feed/articles" rel="alternate" title="فید مقالات" type="application/rss+xml">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">وبسایت </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="#">دوره‌ها</a>
                </li>
                <li>
                    <a href="#">مقالات</a>
                </li>
                <li>
                    <a href="#">درباره‌ما</a>
                </li>
                @if(!auth()->check())
                    <li>
                        <a href="/login">ورود</a>
                    </li>
                @else
                    <li>
                        <a href="/user/panel">حساب کاربری</a>
                    </li>
                    <li>
                        <a href="/logout">خروج</a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->



        @yield('content')



<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Shahram_peyvandi 2019</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->


<script src="{{asset('js/app.js')}}"></script>
<script src="js/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
{{--<script src='https://vjs.zencdn.net/7.6.0/video.js'></script>--}}
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/personal.js')}}"></script>

<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>

</html>
