<x-layouts.app>
    <x-page-header image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
            Zante Event Packages
            </x-slot>
            <p>A-List gives you Zante's biggest DJ & Artist Line-Up hosted at the best venues on the island.</p>
           {{--  <p>Enjoy the best music in Zante at the top venues on the island and and experience world-class events with huge crowds guaranteed.</p>
            <p>We are now taking last orders for the closing party’s September 2023</p> --}}
    </x-page-header>
    {{-- intro --}}
    <div class="pt-20 pb-20">
        <div class="relative px-6 text-center text-black">
            <h2 data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="whitespace-pre text-xs font-bold tracking-widest text-black/60 sm:text-sm uppercase">ZANTE'S #1 SELLING EVENT PACKAGE</h2>
            <x-ui.title>Zante Event Packages</x-ui.title>
        </div>
        <div data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="mt-12 max-w-3xl mx-auto px-6 prose text-black/60 text-lg text-center leading-relaxed relative z-20">
            <p>Our A-List Zante Events package is in cooperation with The White Party, DJ Nathan Dawe, Karma Day Club & IKON Club and is completely sold out online every Summer.</p>
            <p>Enjoy the best music in Zante at the top venues on the island and and experience world-class events with huge crowds guaranteed.</p>
        </div>
    </div>
    @foreach ($events as $event)
        <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-y-12 lg:gap-y-12 gap-x-24">
            <div>
                {{-- <h4 data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="whitespace-pre text-xs font-bold tracking-widest text-black/60 sm:text-sm uppercase">Now 95% sold out for Summer 2023 – BOOK NOW!</h4> --}}
                <div class="text-black">
                    <x-ui.title>{{ $event->name }}</x-ui.title>
                </div>
                <div data-sal="fade" data-sal-duration="500" data-sal-easing="ease-in-out" class="mt-12 prose text-black/60 max-w-none">
                    {!! $event->description !!}
                </div>
                <div data-sal="slide-up" data-sal-duration="1000" data-sal-easing="ease-in-out" class="mt-6">
                    <a class="inline-block bg-black font-bold text-white border-2 border-black hover:bg-brand hover:text-white hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all ease-in-out px-8 py-3 uppercase" href="/book">Book {{ $event->name }}</a>
                </div>
            </div>
            <div>
                {{ $event->getFirstMedia('images')?->img()->attributes([
                    'alt' => $event->name,
                    'class' => 'h-64 lg:h-full w-full object-cover ',
                    'data-sal' => 'slide-right',
                    'data-sal-duration' => '1000',
                    'data-sal-easing' => 'ease-in-out',
                ]) }}
            </div>
        </div>
        <div class="grid grid-cols-4 gap-6 container mx-auto px-6 py-12 lg:py-24">
            @foreach ($event->getMedia('images')->skip(1) as $image)
                <div class="relative h-96">
                    {{ $image?->img()->attributes([
                        'class' => 'h-full w-full object-cover ',
                        'data-sal' => 'slide-up',
                        'data-sal-delay' => $loop->index * 200,
                        'data-sal-duration' => '500',
                        'data-sal-easing' => 'ease-in-out',
                    ]) }}
                </div>
            @endforeach
        </div>
    @endforeach
    <x-newsletter></x-newsletter>
</x-layouts.app>
