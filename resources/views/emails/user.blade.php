@component('mail::message')
# Hello {{$user->email}}

Thanks for registering 

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
