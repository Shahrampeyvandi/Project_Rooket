@extends('layouts.app')

@section('content')
<ul class="nav nav-tabs nav-right">
    <li class="nav-item" >
        <a class="nav-link {{ Route::currentRouteName() == 'user.panel' ? 'active' : '' }}" href="{{route('user.panel')}}">اطلاعات کاربری</a>
    </li>
    <li class="nav-item" >
        <a class="nav-link {{ Route::currentRouteName() == 'user.panel.history' ? 'active' : '' }}" href="{{route('user.panel.history')}}">پرداخت های انجام شده</a>
    </li>
    <li class="nav-item" >
        <a class="nav-link {{ Route::currentRouteName() == 'user.panel.vip' ? 'active' : '' }}" href="{{route('user.panel.vip')}}">شارژ vip</a>
    </li>
</ul>
 {{ $slot }}

@endsection
