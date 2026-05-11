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
<body class="bg-[#fff7ef] @if (!str_contains($slot->toHtml(), 'x-data="hero"')) overflow-x-hidden @endif {{-- cursor-brand --}}">

    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-[42rem] bg-[radial-gradient(circle_at_top_left,_rgba(255,111,176,0.35),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(255,214,10,0.28),_transparent_30%),linear-gradient(180deg,_rgba(255,247,239,1)_0%,_rgba(255,247,239,0.96)_55%,_rgba(255,247,239,1)_100%)]" style="z-index: -1;"></div>
    <div aria-hidden="true" class="pointer-events-none absolute left-[-5rem] top-24 h-40 w-40 rounded-full border-4 border-black/80 bg-[#ffd54a] blur-[2px] hidden lg:block"></div>
    <div aria-hidden="true" class="pointer-events-none absolute right-[-4rem] top-[28rem] h-32 w-32 rounded-[2rem] border-4 border-black/80 bg-[#7fe7ff] rotate-12 hidden lg:block"></div>
    
    @include('partials.body')
    @if (session('booking_site') === 'zec' && request()->routeIs('book.*'))
        <div class="flex items-center justify-center py-12 -mb-48">
            <img src="https://zanteeventcompany.netlify.app/assets/images/logo.webp" class="h-24 w-auto" />
        </div>
    @else
        <x-header></x-header>
    @endif

    <div class="@if (!(session('booking_site') === 'zec' && request()->routeIs('book.*'))) pt-28 sm:pt-32 @endif">
        {{ $slot }}
    </div>

        <x-footer></x-footer>
    @if ($popup)
        <x-popup :popup="$popup"></x-popup>
    @endif
    <x-notifications></x-notifications>
    @stack('scripts')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>