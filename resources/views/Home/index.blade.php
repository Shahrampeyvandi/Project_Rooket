@extends('Home.master')

@section('content')

    <!-- Jumbotron Header -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Logo </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                   @if(count($menus))
                       @foreach($menus as $menu)
                            <li><a href="{{ $menu->url }}">{{ $menu->title }}</a></li>
                        @endforeach
                   @endif
                    @auth
                        <li><a href="{{ route('user.panel') }}">حساب کاربری</a></li>

                        <li><a href="{{ route('logout') }}">خروج</a></li>
                    @else
                        <li><a href="{{ route('login') }}">ورود</a></li>

                    @endauth

                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">بخش ها <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">دوره ها</a></li>
                            <li><a href="#">مقالات </a></li>
                            <li><a href="#">محصولات  </a></li>

                        </ul>
                    </li>
                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div class="banner">
        <div class="bg-color">
            <div class="container">
                <div class="row">
                    <div class="banner-text text-center">
                        <div class="text-border">
                            <h2 class="text-dec" style="font-family: IRANSans;padding: 20px">بروزترین ها  </h2>
                        </div>
                        <div class="intro-para text-center quote">
                            <p class="big-text">با ما اینده فرزندانتان را تامین کنید</p>
                            <p class="small-text">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                            <a href="#footer" class="btn get-quote">GET A QUOTE</a>
                        </div>
                        <a href="#feature" class="mouse-hover">
                            <div class="mouse"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    <hr>
    <div class="row">

        <div class="col-lg-12">

            <h3 class="paddingbottom head">آخرین دوره ها</h3>
        </div>
    </div>
    <div class="row ">
        @forelse($courses as $course)
{{--            <div class="col-md-3 col-sm-6 hero-feature" style="height: 400px">--}}
{{--                <div class="thumbnail">--}}
{{--                    <img class=" img-fluid" style="height: 200px" src="{{asset($course->images['images']['300'])}}" alt="">--}}
{{--                    <div class="caption">--}}
{{--                    <h3><a href="{{$course->path()}}"> {{$course->title}}</a></h3>--}}
{{--                        <p>   {{str_limit($course->description,120)}}</p>--}}
{{--                        <p>--}}
{{--                            <a href="{{$course->path()}}" class="btn btn-primary">خرید</a> <a href="#" class="btn btn-default">اطلاعات بیشتر</a>--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    <div class="ratings">--}}
{{--                        <p class="pull-left">{{$course->viewCount}} بازدید</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

           <div class="col-md-4 col-sm-6 hero-feature " >
            <div class="card " style="width: 30rem;margin-bottom: 20px">
                <img style="height: 300px"  class="card-img-top img-responsive"  src="{{asset($course->images['images']['300'])}}" alt="Card image cap">
                <div class="card-body" >
                    <h5 class="card-title"><a href="{{$course->path()}}"> {{$course->title}}</a></h5>
                    <p class="card-text" style="">{{str_limit($course->description,120)}}</p>
                    <div class="btn btn-group-xs quote" style="width: 100%">
                        <p href="#" class="btn btn-info" style="margin-left: 40px">تعداد بازدید:{{$course->viewCount}}</p>
                        <a href="{{$course->path()}}" class="btn get-quote">ادامه مطلب</a>

                    </div>
                </div>
            </div>
           </div>
        @empty
            <div class="alert alert-info">
                موردی برای نمایش وجود ندارد
            </div>
        @endforelse
</div>


    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="paddingbottom head">مقالات</h3>
            </div>
        </div>
        <div class="row">
           @forelse ($articles as $article)
           <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <img src="{{asset($article->images['images']['300'])}}" alt="">
                    <div class="caption">
                    <h4><a href="{{$article->path()}}">{{$article->title}}</a>
                        </h4>
                        <p>{{str_limit($article->description,150)}} <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">15 بازدید</p>
                    </div>
                </div>
            </div>
           @empty
            <div class="alert alert-info">
                موردی وجود ندارد
            </div>
           @endforelse
        </div>
        </div>
    </div>

</div>
@endsection
