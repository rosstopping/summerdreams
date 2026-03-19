
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.5.x/dist/css/glide.core.min.css">
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.5.x"></script>


<div class="relative">
    <div class="bg-white">
        @if($content->background_image)
            <img src="{{ Storage::url($content->background_image) }}" alt="THIS IS ZANTE" class="absolute inset-0 w-full h-full object-cover object-center opacity-50">
        @endif
        <div class="absolute bottom-0 left-0 w-full h-[100vh] bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    </div>

    @if($content->show_logo)
        <div class="flex items-center justify-center lg:justify-start relative z-10 top-6 md:top-12 w-full px-6 z-50">
            <a href="/">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-16 w-auto block">
            </a>
        </div>
    @endif

    <div :class="scrollDistance > 1000 ? '-z-10' : 'z-10'" class="w-screen h-screen text-white flex items-center justify-center fixed inset-0">
        <div :style="{ opacity: textOpacity, transform: `scale(${textScale}) translateY(${textTransformY}px)` }" class="text-center absolute z-10 -mt-64">
            <div class="text-[clamp(2rem,7vw,7rem)]  md:text-[clamp(1.5rem,5vw,7rem)] tracking-widest font-normal leading-none">
                @foreach($eyebrow = explode(' ', $content->title_line_1 ?? 'THIS IS') as $word)
                    <span class="inline-block" data-aos-duration="500" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">{{ $word }}</span>{{ !$loop->last ? ' ' : '' }}
                @endforeach
            </div>
            <div data-aos-duration="800" data-aos="fade-up" data-aos-delay="{{ count($eyebrow) * 150 + 150 }}" class="text-[clamp(6rem,20vw,24rem)] md:text-[clamp(4.5rem,17vw,24rem)] font-bold tracking-wide leading-none mt-2 md:-mt-1">{{ $content->title_line_2 ?? 'ZANTE' }}</div>
        </div>
    </div>

    {{-- fake element to allow scrolling --}}
    <div x-ref="scrollSpacing" class="h-[100vh]"></div>

    {{-- the scroller --}}
    <div x-ref="scroller" class="sticky bottom-0 py-12">
        <div x-cloak :class="scrolledIntoPlace ? 'opacity-100' : 'opacity-0'" class="py-6 px-4 lg:px-12 transition-opacity ease-in duration-300">
            <h2 class="text-white text-3xl lg:text-5xl sm:text-4xl font-black leading-10 md:leading-normal font-display z-20 md:max-w-full md:px-0 tracking-wide md:tracking-wide lg:tracking-wide uppercase">{{ $content->events_title ?? 'The Events' }}</h2>
        </div>
        {{-- desktop --}}
        <div x-ref="glide" class="glide hidden md:block px-4 lg:px-12 transition-transform duration-700 ease-out z-20 select-none">
            <div class="glide__track" data-glide-el="track">
                <ul class="relative glide__slides">
                    @if($content->event_slides)
                        @foreach($content->event_slides as $index => $slide)
                            @if($slide->layout === 'event_slide')
                                <li data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 + 500 }}" data-aos-once="true" class="glide__slide flex flex-col items-center justify-center">
                                    @if(isset($slide->attributes->event_url) && $slide->attributes->event_url)
                                        <a href="{{ $slide->attributes->event_url }}" class="block w-full h-full">
                                    @endif
                                        <div :class="scrolledIntoPlace ? 'h-64 lg:h-96' : 'h-32 lg:h-96'" 
                                             @if($index < 4)
                                             @switch($index)
                                                 @case(0)
                                                     :style="{transform: `scale(${eventTileOneScale}) skewX(${eventTileOneSkewX}deg) skewY(${eventTileOneSkewY}deg)`}"
                                                     @break
                                                 @case(1)
                                                     :style="{transform: `scale(${eventTileTwoScale}) skewX(${eventTileTwoSkewX}deg) skewY(${eventTileTwoSkewY}deg)`}"
                                                     @break
                                                 @case(2)
                                                     :style="{transform: `scale(${eventTileThreeScale}) skewX(${eventTileThreeSkewX}deg) skewY(${eventTileThreeSkewY}deg)`}"
                                                     @break
                                                 @case(3)
                                                     :style="{transform: `scale(${eventTileFourScale}) skewX(${eventTileFourSkewX}deg) skewY(${eventTileFourSkewY}deg)`}"
                                                     @break
                                             @endswitch
                                             @endif
                                             class="w-full relative flex flex-col items-start justify-end transition-height {{ (isset($slide->attributes->event_url) && $slide->attributes->event_url) ? 'cursor-pointer' : '' }}">

                                            <div :class="scrolledIntoPlace ? 'opacity-100' : 'opacity-0'" class="relative z-10 p-4 lg:p-6 text-white transition-opacity ease-in-out duration-700">
                                                <h3 class="text-xs lg:text-2xl">{{ $slide->attributes->event_name ?? '' }}</h3>
                                            </div>

                                            @if($slide->attributes->event_image)
                                                <img class="absolute inset-0 w-full h-full object-cover " src="{{ Storage::url($slide->attributes->event_image) }}" alt="{{ $slide->attributes->event_name ?? 'Event' }}">
                                            @endif

                                            <div x-cloak :class="scrolledIntoPlace ? 'opacity-75' : 'opacity-0'" class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black via-black/50 to-transparent  transition-opacity ease-in-out"></div>
                                        </div>
                                    @if(isset($slide->attributes->event_url) && $slide->attributes->event_url)
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @else
                        {{-- Fallback content if no slides are configured --}}
                        <li data-aos="fade-up" data-aos-delay="100" data-aos-once="true" class="glide__slide flex flex-col items-center justify-center">
                            <div :class="scrolledIntoPlace ? 'h-64 lg:h-96' : 'h-32 lg:h-96'" :style="{transform: `scale(${eventTileOneScale}) skewX(${eventTileOneSkewX}deg) skewY(${eventTileOneSkewY}deg)`}" class="w-full relative flex flex-col items-start justify-end transition-height">
                                <div :class="scrolledIntoPlace ? 'opacity-100' : 'opacity-0'" class="relative z-10 p-4 lg:p-6 text-white transition-opacity ease-in-out duration-700">
                                    <h3 class="text-xs lg:text-2xl">Sample Event</h3>
                                </div>
                                <div class="absolute inset-0 w-full h-full bg-gray-800 "></div>
                                <div x-cloak :class="scrolledIntoPlace ? 'opacity-75' : 'opacity-0'" class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black via-black/50 to-transparent  transition-opacity ease-in-out"></div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- mobile --}}
        <div x-ref="glideMobile" class="glide block md:hidden px-4 lg:px-12 transition-transform duration-700 ease-out z-20 select-none">
            <div class="glide__track" data-glide-el="track">
                <ul class="relative glide__slides">
                    @if($content->event_slides)
                        @foreach($content->event_slides as $index => $slide)
                            @if($slide->layout === 'event_slide')
                                <li data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 + 2000 }}" data-aos-once="true" class="glide__slide flex flex-col items-center justify-center">
                                    @if(isset($slide->attributes->event_url) && $slide->attributes->event_url)
                                        <a href="{{ $slide->attributes->event_url }}" class="block w-full h-full">
                                    @endif
                                        <div :class="scrolledIntoPlace ? 'h-64 lg:h-96' : 'h-64 lg:h-96'" 
                                             @if($index < 4)
                                             @switch($index)
                                                 @case(0)
                                                     :style="{transform: `scale(${eventTileOneScale}) skewX(${eventTileOneSkewX}deg) skewY(${eventTileOneSkewY}deg)`}"
                                                     @break
                                                 @case(1)
                                                     :style="{transform: `scale(${eventTileFourScale}) skewX(${eventTileFourSkewX}deg) skewY(${eventTileFourSkewY}deg)`}"
                                                     @break
                                             @endswitch
                                             @endif
                                             class="w-full relative flex flex-col items-start justify-end transition-height {{ (isset($slide->attributes->event_url) && $slide->attributes->event_url) ? 'cursor-pointer' : '' }}">

                                            <div :class="scrolledIntoPlace ? 'opacity-100' : 'opacity-0'" class="relative z-10 p-4 lg:p-6 text-white transition-opacity ease-in-out duration-700">
                                                <h3 class="text-xs lg:text-2xl">{{ $slide->attributes->event_name ?? '' }}</h3>
                                            </div>

                                            @if($slide->attributes->event_image)
                                                <img class="absolute inset-0 w-full h-full object-cover " src="{{ Storage::url($slide->attributes->event_image) }}" alt="{{ $slide->attributes->event_name ?? 'Event' }}">
                                            @endif

                                            <div x-cloak :class="scrolledIntoPlace ? 'opacity-75' : 'opacity-0'" class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black via-black/50 to-transparent  transition-opacity ease-in-out"></div>
                                        </div>
                                    @if(isset($slide->attributes->event_url) && $slide->attributes->event_url)
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @else
                        {{-- Fallback content if no slides are configured --}}
                        <li data-aos="fade-up" data-aos-delay="100" data-aos-once="true" class="glide__slide flex flex-col items-center justify-center">
                            <div :class="scrolledIntoPlace ? 'h-64 lg:h-96' : 'h-32 lg:h-96'" :style="{transform: `scale(${eventTileOneScale}) skewX(${eventTileOneSkewX}deg) skewY(${eventTileOneSkewY}deg)`}" class="w-full relative flex flex-col items-start justify-end transition-height">
                                <div :class="scrolledIntoPlace ? 'opacity-100' : 'opacity-0'" class="relative z-10 p-4 lg:p-6 text-white transition-opacity ease-in-out duration-700">
                                    <h3 class="text-xs lg:text-2xl">Sample Event</h3>
                                </div>
                                <div class="absolute inset-0 w-full h-full bg-gray-800 "></div>
                                <div x-cloak :class="scrolledIntoPlace ? 'opacity-75' : 'opacity-0'" class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black via-black/50 to-transparent  transition-opacity ease-in-out"></div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>