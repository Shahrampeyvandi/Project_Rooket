@component('Home.panel.master')
    <ul style="margin: 20px">
        <li>   نام کاربری :{{auth()->user()->name}}</li>
        <li>ایمیل : {{auth()->user()->email}}</li>
        @if(auth()->user()->isActive())
            <li>  پایان اعتبار شما{{ \Carbon\Carbon::parse(auth()->user()->viptime)->diffInDays() }}</li>
        @else
            <li>  شما عضو ویژه نیستید</li>
        @endif

    </ul>


@endcomponent