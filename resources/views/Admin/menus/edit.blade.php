@extends('Admin.master')



@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="page-header head-section">
            <h2> ویرایش</h2>
        </div>
        <form class="form-horizontal" action="{{ route('menus.update') }}" method="post">
            {{ csrf_field() }}
            @method('PUT')
            @include('Admin.section.errors')
            <div class="form-group">
                <div class="col-sm-6">
                    <label for="title" class="control-label">عنوان</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید" value="{{ $menu->title }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="position" class="control-label">جایگاه</label>
                    <input type="number"  class="form-control" name="position" id="position" value="{{ $menu->position }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="url" class="control-label">لینک</label>
                    <input type="text"  class="form-control" name="url" id="url" value="{{ $menu->url }}">
                </div>
            </div>




            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-danger">ارسال</button>
                </div>
            </div>
        </form>
    </div>
@endsection
