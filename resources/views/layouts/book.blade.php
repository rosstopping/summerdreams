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
<body class="bg-gray-100 @if (!str_contains($slot->toHtml(), 'x-data="hero"')) overflow-x-hidden @endif {{-- cursor-brand --}}">
    @include('partials.body')
    <x-header></x-header>
    <div class="pt-28 sm:pt-32">
        {{ $slot }}
    </div>
    <x-footer></x-footer>
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