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
                    <th style="width: 600px">  مقدار پرداختی</th>
                    <th> نوع پرداخت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->user->name }}</td>
                        <td style="width: 600px">{{ $payment->price}}</td>
                        @if($payment->course_id == 'vip')
                            <td>این یک دوره ی ویژه است</td>
                        @else
                        <td>{{ $payment->course->title }}</td>
                        @endif
                        <td>
                            <form action="{{ route('payments.destroy'  , ['id' => $payment->id]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="btn-group btn-group-xs">
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
            {!! $payments->render() !!}
        </div>
    </div>
@endsection