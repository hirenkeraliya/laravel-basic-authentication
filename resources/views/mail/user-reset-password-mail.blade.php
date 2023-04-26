<x-mail::message>
# Reset Password

Hi, {{ $user->name }}

[Click Here]({{ route('password.reset', ['token' => $token]) }}) to reset password.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
