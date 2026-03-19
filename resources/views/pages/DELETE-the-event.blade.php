<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="relative z-10 pt-20 pb-32">
        <div class="mx-auto container px-6">
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-8 overflow-hidden lg:mx-0 lg:max-w-none lg:grid-cols-4">
                <div>
                    <time datetime="2021-08" class="flex items-center text-sm font-semibold leading-6 text-gray-900">
                        <svg viewBox="0 0 4 4" class="mr-4 h-1 w-1 flex-none" aria-hidden="true">
                            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        </svg>
                        Step 1
                        <div class="absolute -ml-2 h-px w-screen -translate-x-full bg-brand opacity-50 sm:-ml-4 lg:static lg:-mr-6 lg:ml-8 lg:w-auto lg:flex-auto lg:translate-x-0" aria-hidden="true"></div>
                    </time>
                    <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-brand">Choose package</p>
                    <p class="mt-1 text-base leading-7 text-gray-900/75">We have packages ranging from £65 to £160 for a full week of events</p>
                </div>
                <div>
                    <time datetime="2021-12" class="flex items-center text-sm font-semibold leading-6 text-gray-900">
                        <svg viewBox="0 0 4 4" class="mr-4 h-1 w-1 flex-none" aria-hidden="true">
                            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        </svg>
                        Step 2
                        <div class="absolute -ml-2 h-px w-screen -translate-x-full bg-brand opacity-50 sm:-ml-4 lg:static lg:-mr-6 lg:ml-8 lg:w-auto lg:flex-auto lg:translate-x-0" aria-hidden="true"></div>
                    </time>
                    <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-brand">Secure tickets</p>
                    <p class="mt-1 text-base leading-7 text-gray-900/75">Pay deposit to lock in your discounted event tickets
                    </p>
                </div>
                <div>
                    <time datetime="2022-02" class="flex items-center text-sm font-semibold leading-6 text-gray-900">
                        <svg viewBox="0 0 4 4" class="mr-4 h-1 w-1 flex-none" aria-hidden="true">
                            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        </svg>
                        Step 3
                        <div class="absolute -ml-2 h-px w-screen -translate-x-full bg-brand opacity-50 sm:-ml-4 lg:static lg:-mr-6 lg:ml-8 lg:w-auto lg:flex-auto lg:translate-x-0" aria-hidden="true"></div>
                    </time>
                    <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-brand">Pick up in Zante</p>
                    <p class="mt-1 text-base leading-7 text-gray-900/75">Pick up your tickets and pay balance when you arrive at our office in Laganas
                    </p>
                </div>
                <div>
                    <time datetime="2022-12" class="flex items-center text-sm font-semibold leading-6 text-gray-900">
                        <svg viewBox="0 0 4 4" class="mr-4 h-1 w-1 flex-none" aria-hidden="true">
                            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        </svg>
                        Step 4
                        <div class="absolute -ml-2 h-px w-screen -translate-x-full bg-brand opacity-50 sm:-ml-4 lg:static lg:-mr-6 lg:ml-8 lg:w-auto lg:flex-auto lg:translate-x-0" aria-hidden="true"></div>
                    </time>
                    <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-brand">Have the best week of your life</p>
                    <p class="mt-1 text-base leading-7 text-gray-900/75">Our mission is for you to have an awesome holiday - and we deliver! 
                    </p>
                </div>
            </div>
        </div>
    </div>
    <section class="pt-4 text-gray-900 md:pt-10 pb-24">
        <div class="wrapper">
            <div class="relative px-6 text-center text-gray-900 z-20 pb-24">
                <div class="max-w-2xl mx-auto">
                    <x-ui.title>What To Expect on the Day - VVIP Yacht Party Timeline</x-ui.title>
                </div>

                <div class="mt-12 max-w-xl mx-auto px-6 prose text-gray-900 text-lg text-center leading-relaxed relative z-20 opacity-50">
                    <p>How the best day of your holiday in Zante plays out
                    </p>
                </div>
            </div>
            <div class="relative z-20 px-4">
                <div class="relative grid grid-cols-2 gap-4 md:grid md:grid-cols-4">
                    {{-- <button type="button" class="absolute z-30  border border-white/10 transition-colors hover:border-white/20  bg-black px-6 py-3 text-xl font-bold text-gray-900 bottom-3 left-1/2 -translate-x-1/2 -translate-y-1/2 transform">See more</button> --}}
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">3:30pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">Pre-party at Karma Day Club</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg relative overflow-hidden">
                        <div class="relative z-20 flex h-full flex-col justify-end relative z-10  p-4 text-gray-900 md:p-6">
                            {{-- <p class="w-full text-base font-semibold md:text-xl">Our first home, Wander Anchor Bay, goes into contract in Gualala, CA</p> --}}
                        </div>
                        <div class="absolute top-0 h-full w-full">
                            <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                            <img alt="" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="{{ Vite::asset('resources/images/white-party-dancers.jpg') }}">
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">4:30pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">Coach transfer to port</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg relative overflow-hidden">
                        <div class="relative z-20 flex h-full flex-col justify-end relative z-10  p-4 text-gray-900 md:p-6">
                            {{-- <p class="w-full text-base font-semibold md:text-xl">Our first home, Wander Anchor Bay, goes into contract in Gualala, CA</p> --}}
                        </div>
                        <div class="absolute top-0 h-full w-full">
                            <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                            <img alt="" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="https://summerdreams.com/wp-content/uploads/2019/03/brittany-phoebe-best-boat-party-zante-1400x1000.jpg">
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">5:00pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">Embark VVIP Super Yacht</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg relative overflow-hidden col-span-2">
                        <div class="relative z-20 flex h-full flex-col justify-end relative z-10  p-4 text-gray-900 md:p-6">
                            {{-- <p class="w-full text-base font-semibold md:text-xl">Our first home, Wander Anchor Bay, goes into contract in Gualala, CA</p> --}}
                        </div>
                        <div class="absolute top-0 h-full w-full">
                            <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                            <img alt="" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="https://summerdreams.com/wp-content/uploads/2019/03/vvip-sunset-yacht-party-1400x1000.jpg">
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">7:00pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">Arrive at Private Beach for group photo and champagne spray. Swimming optional</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg relative overflow-hidden">
                        <div class="relative z-20 flex h-full flex-col justify-end relative z-10  p-4 text-gray-900 md:p-6">
                            {{-- <p class="w-full text-base font-semibold md:text-xl">Our first home, Wander Anchor Bay, goes into contract in Gualala, CA</p> --}}
                        </div>
                        <div class="absolute top-0 h-full w-full">
                            <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                            <img alt="" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="https://summerdreams.com/wp-content/uploads/2019/03/zante-booze-cruise-2-1-1400x1000.jpg">
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">7:45pm - 9:15pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">VVIP now in full swing, enjoy a beautiful Zante sunset and a memorable party</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg p-4 md:p-6">
                        <div class="relative z-20 flex h-full flex-col justify-end w-full">
                            <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">9:30pm</h2>
                            <p class="w-full text-base font-semibold md:text-xl">Coach transfer back to Laganas</p>
                        </div>
                    </div>
                    <div class="h-60 w-full   bg-white shadow-lg relative overflow-hidden">
                        <div class="relative z-20 flex h-full flex-col justify-end relative z-10  p-4 text-gray-900 md:p-6">
                            {{-- <p class="w-full text-base font-semibold md:text-xl"></p> --}}
                        </div>
                        <div class="absolute top-0 h-full w-full">
                            <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                            <img alt="" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-7-1400x1000.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="relative isolate mx-auto w-full py-12 overflow-hidden">
        <div class="scrollbar-hide group mb-6 w-full">
            <div x-data="scroller" @scroll.window="onScroll" class="relative h-full w-max">
                <div class="grid h-full w-full grid-flow-col items-stretch gap-6">
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-22-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2020/09/best-zante-boat-party-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-1-1-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/vvip-zante-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-22-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2020/09/best-zante-boat-party-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-1-1-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/vvip-zante-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/zante-boat-party-1-1-1400x1000.jpg" class="h-64 w-auto " />
                    <img src="https://summerdreams.com/wp-content/uploads/2019/03/vvip-zante-1400x1000.jpg" class="h-64 w-auto " />
                </div>
            </div>
        </div>
    </section>
    <x-reviews></x-reviews>
    <x-newsletter></x-newsletter>
</x-layouts.app>
