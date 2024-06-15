<x-mail::message>
# Introduction

Task _{{ $title }}_ have been assigned to you.

<x-mail::button :url="$url" color="success" >
Button Text
</x-mail::button>

<img class="text-center" src="{{ $message->embed(public_path('ok.jpeg')) }}">



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
