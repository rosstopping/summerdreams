<!DOCTYPE html>
<html lang="en" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo::meta />
    @vite(['resources/css/app.css'])
    @vite('webfonts.css')
    @include('partials.head')
</head>
<body class="bg-gray-100 overflow-x-hidden {{-- cursor-brand --}}">
    <img src="/images/logo-dark.png" alt="{{ config('app.name') }}" class="h-20 my-6 w-auto mx-auto" />

    {{ $slot }}
    <x-notifications></x-notifications>
</body>
</html>