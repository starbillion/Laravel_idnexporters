@component('mail::message')

{{ $user->name }},
{{ config('emails.authentication.register.body') }}

@component('mail::button', ['url' => route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) ])
{{ config('emails.authentication.register.button') }}
@endcomponent

@component('mail::subcopy')
If you’re having trouble clicking the "{{ config('emails.authentication.register.button') }}" button, copy and paste the URL below
into your web browser: [{{ route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}]({{ route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }})
@endcomponent
@endcomponent
