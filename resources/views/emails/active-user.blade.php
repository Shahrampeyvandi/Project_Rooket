@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => route('activation.account',$code)])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
