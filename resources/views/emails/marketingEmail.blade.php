@component('mail::message')
    # {{ $subjectText }}

    {{ $emailText }}

    Thanks,
    {{ $appName }}
@endcomponent

