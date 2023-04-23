<x-mail::message>
# Welcome

Hi, {{ $secondUser->name }}

Welcome to {{ config('app.name') }}

| Username | Password |
| ------------ |:--------:|
| {{ $secondUser->email }} | {{ $password }} |


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
