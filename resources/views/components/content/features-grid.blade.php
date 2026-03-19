<section class="relative z-20 w-full overflow-hidden">
    <div class="relative grid md:grid-cols-2 bg-black">
        @if (data_get($content, 'button_text'))
            <div class="absolute hidden md:block top-1/2 left-1/2 z-20 -translate-x-1/2 -translate-y-1/2 transform">
                <x-ui.button href="{{ data_get($content, 'button_link') }}">{{ data_get($content, 'button_text') }}</x-ui.button>
            </div>
        @endif
        <div class="relative flex items-end md:items-center h-64 md:h-96 2xl:h-[25vw] group">
            <div data-sal="fade" data-sal-duration="500" class="absolute h-full w-full">
                <img alt="Sunset Cruise Zante" class="h-full w-full object-cover" src="{{ Storage::url(data_get($content, 'tile_1_image')) }}" />
            </div>
            <div class="absolute bottom-0 left-0 w-full h-full bg-linear-to-tr from-black"></div>
            <div class="absolute inset-0 w-full h-full bg-black opacity-0 group-hover:opacity-75 transition-all ease-in-out duration-500"></div>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="500" class="relative z-20 px-5 pb-5 md:px-16 md:pb-0">
                <h2 class="mt-5 mb-4 text-3xl font-bold xl:text-4xl text-white">{{ data_get($content, 'tile_1_title') }}</h2>
                <p class="max-w-md text-lg leading-6 text-white/90 xl:text-xl xl:leading-7">
                    {{ data_get($content, 'tile_1_description') }}
                </p>
            </div>
        </div>
        <div class="relative flex items-end md:items-center h-64 md:h-96 2xl:h-[25vw] justify-end group">
            <div data-sal="fade" data-sal-duration="500" data-sal-delay="500" class="absolute h-full w-full">
                <img alt="VIP Tables Zante" class="h-full w-full object-cover" src="{{ Storage::url(data_get($content, 'tile_2_image')) }}" />
            </div>
            <div class="absolute bottom-0 right-0 w-full h-full bg-linear-to-tl from-black"></div>
            <div class="absolute inset-0 w-full h-full bg-black opacity-0 group-hover:opacity-75 transition-all ease-in-out duration-500"></div>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="1000" class="relative z-20 px-5 pb-5 md:px-16 md:pb-0 text-right">
                <h2 class="mt-5 mb-4 text-3xl font-bold xl:text-4xl text-white">{{ data_get($content, 'tile_2_title') }}</h2>
                <p class="max-w-md text-lg leading-6 text-white/90 xl:text-xl xl:leading-7">
                    {{ data_get($content, 'tile_2_description') }}
                </p>
            </div>
        </div>
        <div class="relative flex items-end md:items-center h-64 md:h-96 2xl:h-[25vw] group">
            <div data-sal="fade" data-sal-duration="500" class="absolute h-full w-full">
                <img alt="Live Music Zante" class="h-full w-full object-cover" src="{{ Storage::url(data_get($content, 'tile_3_image')) }}" />
            </div>
            <div class="absolute bottom-0 left-0 w-full h-full bg-linear-to-tr from-black"></div>
            <div class="absolute inset-0 w-full h-full bg-black opacity-0 group-hover:opacity-75 transition-all ease-in-out duration-500"></div>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="500" class="relative z-20 px-5 pb-5 md:px-16 md:pb-0">
                <h2 class="mt-5 mb-4 text-3xl font-bold xl:text-4xl text-white">{{ data_get($content, 'tile_3_title') }}</h2>
                <p class="max-w-md text-lg leading-6 text-white/90 xl:text-xl xl:leading-7">
                    {{ data_get($content, 'tile_3_description') }}
                </p>
            </div>
        </div>
        <div class="relative flex items-end md:items-center h-64 md:h-96 2xl:h-[25vw] justify-end group">
            <div data-sal="fade" data-sal-duration="500" data-sal-delay="500" class="absolute h-full w-full">
                <img alt="Champagne Showers Zante" class="h-full w-full object-cover" src="{{ Storage::url(data_get($content, 'tile_4_image')) }}" />
            </div>
            <div class="absolute bottom-0 right-0 w-full h-full bg-linear-to-tl from-black"></div>
            <div class="absolute inset-0 w-full h-full bg-black opacity-0 group-hover:opacity-75 transition-all ease-in-out duration-500"></div>
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="1000" class="relative z-20 px-5 pb-5 md:px-16 md:pb-0 text-right">
                <h2 class="mt-5 mb-4 text-3xl font-bold xl:text-4xl text-white">{{ data_get($content, 'tile_4_title') }}</h2>
                <p class="max-w-md text-lg leading-6 text-white/90 xl:text-xl xl:leading-7">
                    {{ data_get($content, 'tile_4_description') }}
                </p>
            </div>
        </div>
        {{-- <div class="absolute bottom-0 z-10 h-1/2 w-full bg-linear-to-t from-black to-transparent"></div> --}}
    </div>
</section>