@component('mail::message')
## Vous avez recu un nouveau message

{{$message}}

<br>
{{ config('app.name') }}
@endcomponent
