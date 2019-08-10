@extends('Admin.master')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="page-header head-section">
            <h2>منو</h2>
            <a href="{{ route('menus.create') }}" class="btn btn-sm btn-primary"> ایتم جدید</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>جایگاه</th>
                    <th>لینک</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menus as $menu)
                    <tr>
                        <td><a href="{{ $menu->url}}">{{ $menu->title }}</a></td>
                        <td>{{ $menu->position }}</td>
                        <td>{{ $menu->url }}</td>
                        <td>
                            <form action="{{ route('menus.destroy'  , ['id' => $menu->id]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="btn-group btn-group-xs">
                                    <a href="{{ route('menus.edit' , ['id' => $menu->id]) }}"  class="btn btn-primary">ویرایش</a>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
