<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="/images/events/vice-parties/IMG_5777.jpg">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="relative overflow-hidden pb-20 pt-8 sm:pt-12">
        {{-- <div class="absolute left-0 top-0 h-96 w-96 -translate-x-1/3 -translate-y-1/3 rounded-full bg-yellow-200 opacity-30 blur-3xl"></div> --}}
        {{-- <div class="absolute bottom-0 right-0 h-96 w-96 translate-x-1/3 translate-y-1/3 rounded-full bg-pink-200 opacity-25 blur-3xl"></div> --}}
        <div class="mx-auto container px-6 relative z-10">
            <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($galleries as $gallery)
                    <article data-sal="slide-up" class="group relative isolate flex flex-col justify-end overflow-hidden rounded-3xl border-4 border-black bg-gray-900 px-8 pb-8 pt-80 shadow-[8px_8px_0px_rgba(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[12px_12px_0px_rgba(0,0,0,0.18)] sm:pt-48 lg:pt-80">
                        {{ $gallery->getFirstMedia('images')?->img()->attributes([
                            'class' => 'absolute inset-0 -z-10 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105',
                        ]) }}
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                        <div class="absolute left-6 top-6 rounded-full border-3 border-black bg-yellow-300 px-4 py-2 text-xs font-black uppercase tracking-tight text-black shadow-[4px_4px_0px_rgba(0,0,0,0.15)]">
                            {{ $gallery->getMedia('images')->count() }} {{ Str::plural('shot', $gallery->getMedia('images')->count()) }}
                        </div>
                        <h3 class="mt-3 text-2xl font-black uppercase leading-tight tracking-tight text-white">
                            @if ($gallery->getMedia('images')->count() > 1)
                                <a href="{{ route('gallery.show', $gallery) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $gallery->name }}
                                </a>
                            @else
                                {{ $gallery->name }}
                            @endif
                        </h3>
                        {{-- <p class="mt-3 text-sm font-bold uppercase tracking-[0.2em] text-white/80">
                            Tap in for the full vibe
                        </p> --}}
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
