@extends('Home.master')


@section('content')
    <!-- Blog Post Content Column -->
    <div class="col-lg-8">

        <!-- Blog Post -->

        <!-- Title -->
        <h1>عنوان  دوره</h1>

        <!-- Author -->
        <p class="lead small">
            توسط <a href="#">حسام موسوی</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> ارسال شده در ۱۲ خرداد ۹۶</p>

        <hr>

        <!-- Post Content -->
        <p dir="rtl">دیمونس در واقع فرایند های پشت زمینه سیستم شما رو در بر می گیره. که معمولا یا در هنگام بوت شدن سیستم شروع به کار میکنه و یا بعد از اینکه به دسکتاپ وارد شدید.</p>

        <p dir="rtl"><strong>Shell</strong></p>

        <p dir="rtl">&nbsp;به احتمال زیاد چیزی به اسم خط فرمان لینوکس رو شنیده باشید. این قسمت رو شل یا پوسته میگن. در واقع جایی هستش که شما می تونید از طریق متن در یک محیط متنی با کامپیوتر ارتباط برقرار کنید. اینجا جاییه که باعث میشه مردم بیشترین ترس رو نسبت به لینوکس پیدا کنند. البته با حضور دسکتاپ های گرافیکی مدرن کمتر برای انجام کارهای روزمره به محیط کامند لاین احتیاج پیدا می کنیم.&nbsp;</p>

        <p dir="rtl"><strong>Graphical Server</strong></p>

        <p dir="rtl">&nbsp;در واقع این قسمت رو میشه یک زیر سیستم به حساب آورد که می تونه گرافیک رو روی صفحه نمایش، نشون بده. اغلب اوقات ما اون رو با اسم X-Server هم می بینیم.</p>
        <hr>
        @if(auth()->check())
            @if(!auth()->user()->isActive())
                <div class="alert alert-danger" role="alert">برای مشاهده تمامی قسمت ها باید عضویت ویژه تهیه کنید</div>
            @else
                <div class="alert alert-success" role="alert"> این دوره در دسترس شمامیباشد</div>
            @endif
        @else
            <div class="alert alert-danger" role="alert">برای مشاهده وارد سایت شوید</div>

        @endif

        <h3>قسمت های دوره</h3>
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>شماره قسمت</th>
                    <th>عنوان قسمت</th>
                    <th>زمان قسمت</th>
                    <th>دانلود</th>
                </tr>
            </thead>
            <tbody>
               @foreach($course->episodes()->latest()->get() as $episode)
                   <tr>
                       <th scope="row">{{ $episode->number }}</th>
                       <td> {{ $episode->title }}</td>
                       <td>{{ $episode->time }}</td>
                       <td>
                           <a href="{{ $episode->download() }}"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                       </td>
                   </tr>
               @endforeach

            </tbody> </table>
        <!-- Blog Comments -->

        <!-- Comments Form -->
        @if(auth()->check())
            <div class="well parent-form">
                @include('Home.errors')
                <h4>ثبت نظر :</h4>
                <form id="myform" role="form" action="/comment" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="parent_id" value="0">
                        <input type="hidden" name="commentable_id" value="{{$course->id}}">
                        <input type="hidden" name="commentable_type" value="{{get_class($course)}}">

                        <textarea class="textarea form-control" rows="3" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ارسال</button>
                </form>
            </div>

        @else
            <div class="alert alert-danger">
                برای مشاهده نظرات باید ثبت نام کنید
            </div>
        @endif
        <hr>

        <!-- Posted Comments -->

        <!-- Comment -->
        @foreach($comments as $comment)
            <div class="media">
                <a class="pull-right" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <small>  {{jdate($comment->created_at)->ago()}}</small>

                        <button data-id="{{$comment->id}}" type="button" class="answer btn btn-xs btn-primary">پاسخ</button>
                        {{$comment->user->name}}
                    </h4>

                    {{$comment->comment}}

                    {{-- nested comments  --}}

                    @if(count($comment->comments))

                        @foreach($comment->comments as $childComment)

                            <div class="media">
                                <a class="pull-right" href="#">
                                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <small>  {{jdate($childComment->created_at)->ago()}}</small>
                                        {{$childComment->user->name}}
                                    </h4>
                                    {{$childComment->comment}}
                                </div>
                            </div>


                        @endforeach



                    @endif
                </div>
            </div>
        @endforeach

    </div>

    <!-- Blog Sidebar Widgets Column -->
{{--    check for if user buy this course--}}
    @if(auth()->check() && auth()->user()->checkLearning($course) )
    <div class="col-md-4">
        <div class="well">
         <h4>شما این دوره را خریداری کرده اید</h4>
        </div>
        @else
            <div class="col-md-4">
                <div class="well">
                    برای استفاده از این دوره نیاز است این دوره را با مبلغ ۱۰۰۰۰ تومان خریداری کنید
                    <form method="post" action="/course/payment">
                        @csrf
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <button type="submit" class="btn btn-xs btn-success">خرید</button>

                    </form>
                </div>

           @endif
        <!-- Blog Search Well -->
        <div class="well">
            <h4>جستجو در سایت</h4>
            <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
            </div>
            <!-- /.input-group -->
        </div>

        <!-- Side Widget Well -->
        <div class="well">
            <h4>دیوار</h4>
            <p>طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد.</p>
        </div>

    </div>

    <div class="modal fade" id="sendCommentModal" tabindex="-1" role="dialog" aria-labelledby="sendCommentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">ارسال پاسخ</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        <input type="hidden" name="parent_id" value="0">
                        <div class="form-group">
                            <label for="message-text" class="control-label">متن پاسخ:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection