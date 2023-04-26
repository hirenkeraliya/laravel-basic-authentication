<x-mail::message>
# Reset Password

Hi, {{ $admin->name }}

[Click Here]({{ route('admin.password.reset', ['token' => $token]) }}) to reset password.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
