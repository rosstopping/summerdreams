<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="pb-12">
        <div class="mx-auto container px-6">
            <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($galleries as $gallery)
                    <article data-sal="slide-up" class="relative isolate flex flex-col justify-end overflow-hidden  bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80 rounded-3xl">
                        {{ $gallery->getFirstMedia('images')?->img()->attributes([
                            'class' => 'absolute inset-0 -z-10 h-full w-full object-cover',
                        ]) }}
                        <div class="absolute inset-0 -z-10 bg-linear-to-t from-gray-900 via-gray-900/40"></div>
                        <div class="absolute inset-0 -z-10  ring-1 ring-inset ring-gray-900/10"></div>
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
                            @if ($gallery->getMedia('images')->count() > 1)
                                <a href="{{ route('gallery.show', $gallery) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $gallery->name }}
                                </a>
                            @else
                                {{ $gallery->name }}
                            @endif
                        </h3>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
