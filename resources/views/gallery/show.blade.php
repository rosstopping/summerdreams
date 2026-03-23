<x-layouts.app>
    <x-page-header :responsiveImage="$gallery->getFirstMedia('images')" image="/images/357826990_657385816431795_986628924903999417_n.jpg">
        <x-slot:title>
            {{ $gallery->name }}
        </x-slot>
        {!! $gallery?->description !!}
    </x-page-header>
    <div class="p-6 md:p-24" x-data='gallery(@json($images))' 
        @keyup.escape.window="exit()"
        @keyup.right.window="change(next())"
        @keyup.left.window="change(prev())">

        <div x-show="fullscreen">
            <div class="z-50 fixed inset-0 w-screen h-screen flex items-center justify-center p-12 bg-black bg-opacity-75">
                <img x-bind:src="images[current]" class="max-h-screen max-w-screen" />
                <div class="z-50 absolute inset-0 w-full h-full flex items-center justify-between">
                    <button x-on:click="change(prev())" type="button" class="pl-12 h-full w-1/2 flex justify-start items-center relative">
                        <div class="absolute inset-0 w-full h-full bg-linear-to-r from-black opacity-25"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button x-on:click="change(next())" type="button" class="pr-12 h-full w-1/2 flex justify-end items-center relative">
                        <div class="absolute inset-0 w-full h-full bg-linear-to-l from-black opacity-25"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="relative h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="z-50 absolute top-0 left-0 w-full pt-6 flex justify-center items-center">
                    <button x-on:click="exit()" class="bg-black text-white  py-2 px-3 flex justify-center items-center text-sm">
                        Exit fullscreen
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($gallery->getMedia('images') as $image)
                <div class="relative md:h-72">
                    {{
                        $image->img()->attributes([
                            'alt' => $image->name,
                            'x-on:click' => 'expand('.$loop->index.')',
                            'class' => 'cursor-pointer w-full h-auto md:h-full md:grow object-cover  md:absolute md:inset-0 rounded-3xl',
                        ])
                    }}
                </div>
            @endforeach
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
