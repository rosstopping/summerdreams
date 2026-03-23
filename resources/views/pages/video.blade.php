<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="/images/357826990_657385816431795_986628924903999417_n.jpg">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="pb-12">
        <div class="mx-auto container px-6">
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($videos as $video)
                    <article class="flex flex-col items-start">
                        <div class="relative w-full">
                            {{-- <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80" alt="" class="aspect-16/9 w-full border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-gray-100 object-cover sm:aspect-2/1 lg:aspect-3/2"> --}}
                            <iframe class="aspect-16/9 w-full border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-gray-100 object-cover sm:aspect-2/1 lg:aspect-3/2" width="560" height="315" src="{{ $video->video }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            {{-- <div class="absolute inset-0  ring-1 ring-inset ring-gray-900/10"></div> --}}
                        </div>
                        <div class="max-w-xl">
                            <div class="group relative mt-6">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    {{ $video->title }}
                                </h3>
                                <p class="mt-5 text-sm leading-6 text-gray-600">{{ $video->description }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
