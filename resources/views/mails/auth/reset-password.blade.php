<x-mail::message>
# Reset your Password

Hello {{$details['name']}},

You are receiving this email because we received a password reset request for your account.

The OTP for your request is:

<x-mail::panel>
    {{$details['otp']}}
</x-mail::panel>

If you did not request a password reset, no further action is required.

Note: This OTP is valid for 5 minutes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
