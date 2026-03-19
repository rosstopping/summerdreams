<!DOCTYPE html>
<html lang="en" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo::meta />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('webfonts.css')
    @include('partials.head')
</head>
<body class="bg-gray-100 {{-- cursor-brand --}}">
    @include('partials.body')
    {{ $slot }}
    <x-notifications></x-notifications>
    @if ($popup)
        <x-popup :popup="$popup"></x-popup>
    @endif
    @stack('scripts')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>