@extends('Admin.master')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="page-header head-section">
            <h2>کامنت ها</h2>
            <a href="{{ route('articles.create') }}" class="btn btn-sm btn-primary">ارساله مقاله</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> نام کاربر</th>
                    <th style="width: 600px"> متن پیام</th>
                    <th> مربوط به</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td><a>{{ $comment->user->name }}</a></td>
                        <td style="width: 600px">{{ $comment->comment }}</td>
                        <td><a href="{{$comment->commentable->path()}}">{{ $comment->commentable->title }}</a></td>
                        <td>
                            <form action="{{ route('comments.destroy'  , ['id' => $comment->id]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="btn-group btn-group-xs">
                                    <a href="{{ route('comments.edit' , ['id' => $comment->id]) }}"  class="btn btn-primary">ویرایش</a>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $comments->render() !!}
        </div>
    </div>
@endsection