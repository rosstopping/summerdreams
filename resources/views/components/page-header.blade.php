@php
    $hasMedia = $image || $responsiveImage;
@endphp

<div class="relative z-20 px-4 sm:px-6 lg:px-8">
    <div class="relative mx-auto max-w-7xl overflow-hidden rounded-[2.25rem] border-4 border-black shadow-[10px_10px_0_0_#171717] sm:shadow-[14px_14px_0_0_#171717] {{ $hasMedia ? 'bg-black' : 'bg-[#fff0be]' }}">
        <div aria-hidden="true" class="pointer-events-none absolute -left-6 top-10 h-20 w-20 rounded-full border-4 border-black bg-[#ffd54a]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -right-6 top-16 h-16 w-16 rotate-12 rounded-[1.1rem] border-4 border-black bg-[#7fe7ff]"></div>

        <div class="relative z-20 px-6 py-12 sm:px-10 sm:py-14 lg:px-12 lg:py-16">
            <p class="text-xs font-black uppercase tracking-[0.26em] {{ $hasMedia ? 'text-[#7fe7ff]' : 'text-black/60' }}">
                Summer Dreams 2026
            </p>

            <h1 class="mt-4 max-w-5xl font-heading text-[clamp(2.2rem,5.8vw,5.2rem)] font-black uppercase leading-[0.9] tracking-[-0.04em] {{ $hasMedia ? 'text-white' : 'text-black' }}">
                {{ $title }}
            </h1>

            <div class="relative z-20 mt-8 max-w-3xl prose text-base leading-relaxed sm:text-lg {{ $hasMedia ? 'prose-invert text-white/90' : 'text-black/75' }}">
                {{ $slot }}
            </div>
        </div>

        @if ($image && !$responsiveImage)
            <img class="absolute inset-0 h-full w-full object-cover opacity-45" src="{{ $image }}" alt="{{ $title }}" />
            <div class="absolute inset-0 h-full w-full bg-[linear-gradient(115deg,rgba(7,7,7,0.28)_0%,rgba(7,7,7,0.55)_42%,rgba(7,7,7,0.85)_100%)]"></div>
            <div class="absolute inset-0 h-full w-full bg-[radial-gradient(circle_at_top_left,_rgba(255,214,74,0.18),_transparent_34%),radial-gradient(circle_at_bottom_right,_rgba(255,111,169,0.26),_transparent_32%)]"></div>
        @endif

        @if ($responsiveImage)
            {{ $responsiveImage->img()->attributes([
                'alt' => $title,
                'class' => 'absolute inset-0 h-full w-full object-cover opacity-45',
                'data-sal' => 'zoom-in',
                'data-sal-duration' => '1000',
                'data-sal-easing' => 'ease-in-out',
            ]) }}
            <div class="absolute inset-0 h-full w-full bg-[linear-gradient(115deg,rgba(7,7,7,0.28)_0%,rgba(7,7,7,0.55)_42%,rgba(7,7,7,0.85)_100%)]"></div>
            <div class="absolute inset-0 h-full w-full bg-[radial-gradient(circle_at_top_left,_rgba(255,214,74,0.18),_transparent_34%),radial-gradient(circle_at_bottom_right,_rgba(255,111,169,0.26),_transparent_32%)]"></div>
        @endif
    </div>
</div>
