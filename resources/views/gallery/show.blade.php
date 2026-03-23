<x-layouts.app>
    <x-page-header :responsiveImage="$gallery->getFirstMedia('images')" image="/images/357826990_657385816431795_986628924903999417_n.jpg">
        <x-slot:title>
            {{ $gallery->name }}
        </x-slot>
        {!! $gallery?->description !!}
    </x-page-header>
    <div class="relative overflow-hidden px-6 py-8 md:px-12 md:py-16 lg:px-24" x-data='gallery(@json($images))' 
        @keyup.escape.window="exit()"
        @keyup.right.window="change(next())"
        @keyup.left.window="change(prev())">

        {{-- <div class="absolute left-0 top-0 h-80 w-80 -translate-x-1/3 -translate-y-1/3 rounded-full bg-yellow-200 opacity-30 blur-3xl"></div> --}}
        {{-- <div class="absolute bottom-0 right-0 h-80 w-80 translate-x-1/3 translate-y-1/3 rounded-full bg-pink-200 opacity-25 blur-3xl"></div> --}}

        <div x-show="fullscreen">
            <div class="fixed inset-0 z-50 flex h-screen w-screen items-center justify-center bg-black/85 p-4 md:p-10">
                <div class="relative flex h-full w-full items-center justify-center rounded-[2rem] border-4 border-black bg-[#FFF7EF] p-4 shadow-[12px_12px_0px_rgba(0,0,0,0.25)] md:p-8">
                <img x-bind:src="images[current]" class="max-h-full max-w-full rounded-[1.5rem] border-4 border-black object-contain" />
                <div class="z-50 absolute inset-0 w-full h-full flex items-center justify-between">
                    <button x-on:click="change(prev())" type="button" class="relative flex h-full w-1/2 items-center justify-start pl-4 md:pl-8">
                        <div class="pointer-events-none absolute left-4 rounded-full border-3 border-black bg-pink-500 p-3 shadow-[4px_4px_0px_rgba(0,0,0,0.2)] md:left-8 md:p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white md:h-10 md:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        </div>
                    </button>
                    <button x-on:click="change(next())" type="button" class="relative flex h-full w-1/2 items-center justify-end pr-4 md:pr-8">
                        <div class="pointer-events-none absolute right-4 rounded-full border-3 border-black bg-pink-500 p-3 shadow-[4px_4px_0px_rgba(0,0,0,0.2)] md:right-8 md:p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white md:h-10 md:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        </div>
                    </button>
                </div>
                <div class="absolute left-0 top-0 z-50 flex w-full items-center justify-center pt-4 md:pt-6">
                    <button x-on:click="exit()" class="flex items-center justify-center rounded-full border-3 border-black bg-white px-4 py-2 text-sm font-black uppercase tracking-tight text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.18)] transition-all hover:bg-yellow-200 md:px-5">
                        Exit fullscreen
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($gallery->getMedia('images') as $image)
                <div class="relative overflow-hidden rounded-3xl border-4 border-black bg-white shadow-[8px_8px_0px_rgba(0,0,0,0.1)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[12px_12px_0px_rgba(0,0,0,0.16)] md:h-72">
                    {{
                        $image->img()->attributes([
                            'alt' => $image->name,
                            'x-on:click' => 'expand('.$loop->index.')',
                            'class' => 'cursor-pointer h-auto w-full object-cover transition-transform duration-300 hover:scale-105 md:absolute md:inset-0 md:h-full md:grow',
                        ])
                    }}
                </div>
            @endforeach
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
