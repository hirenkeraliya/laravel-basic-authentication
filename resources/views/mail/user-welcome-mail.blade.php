<x-mail::message>
# Welcome

Hi, {{ $user->name }}

Welcome to {{ config('app.name') }}

| Username | Password |
| ------------ |:--------:|
| {{ $user->email }} | {{ $password }} |


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
