<div class="relative -mt-28 overflow-hidden pt-28 text-gray-950 sm:-mt-32 sm:pt-32">
    <section class="relative px-4 pb-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="relative isolate overflow-hidden rounded-[2.5rem] border-4 border-black bg-[#ff6fa9] shadow-[10px_10px_0_0_#171717] sm:shadow-[14px_14px_0_0_#171717]">
                <div x-data="slideshow({{ $content->getMedia('images')->count() }})" class="absolute inset-0 w-full h-full bg-black">
                    @foreach ($content->getMedia('images') as $slide)
                        {{
                            $slide->img()->attributes([
                                'alt' => 'Fantasy Boat Party '. $slide->name,
                                'x-bind:class' => 'current === '.$loop->iteration.' ? \'opacity-50 z-10 scale-100 skew-y-0 skew-x-0\' : \'opacity-0 z-10 scale-150\'',
                                'class' => 'absolute inset-0 w-full h-full object-cover object-center transition-all duration-1000 ease-in-out',
                            ])
                        }}
                    @endforeach
                    @if ($content->getMedia('images')->count() > 1)
                        <div class="absolute bottom-0 left-0 w-full z-20 px-6">
                            <div class="w-full max-w-xl mx-auto pb-8 flex gap-2 md:gap-1">
                                <template x-for="index in count">
                                    <div x-on:click="change(index)" type="button" x-bind:class="index === current ? 'opacity-75' : 'opacity-25'" class="bg-white h-2 flex-1 cursor-pointer"></div>
                                </template>
                            </div>
                        </div>
                    @endif
                </div>
                {{-- <img
                    src="/images/events/pambos/IMG_5768.jpg"
                    alt="Ayia Napa coastline and beach clubs"
                    class="absolute inset-0 h-full w-full object-cover"
                > --}}
                <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(7,7,7,0.2)_0%,rgba(7,7,7,0.35)_34%,rgba(7,7,7,0.7)_72%,rgba(7,7,7,0.9)_100%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,214,74,0.30),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(255,111,169,0.45),_transparent_28%)]"></div>

                <div class="relative z-20 grid min-h-[39rem] content-end px-6 py-8 sm:min-h-[44rem] sm:px-10 sm:py-10 lg:min-h-[48rem] lg:grid-cols-[minmax(0,1fr)_16rem] lg:px-14 lg:py-14">
                    <div class="max-w-3xl text-white">

                        <h1 class="max-w-4xl font-heading text-[clamp(3.5rem,9vw,8rem)] font-black uppercase leading-[0.88] tracking-[-0.04em]" style="text-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);">
                            {{ data_get($content, 'title') }}
                        </h1>

                        <div class="mt-6 max-w-2xl text-base font-bold uppercase leading-6 tracking-[0.16em] text-white/95 sm:text-lg sm:leading-8 lg:text-xl">
                            {!! data_get($content, 'description') !!}
                        </div>

                        {{-- <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a href="/book" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-6 py-3 text-sm font-black uppercase tracking-[0.18em] text-black transition-transform duration-200 hover:-translate-y-1">
                                Book Your Week
                            </a>
                            <a href="/event" class="inline-flex items-center justify-center rounded-full border-2 border-white bg-white/10 px-6 py-3 text-sm font-black uppercase tracking-[0.18em] text-white backdrop-blur-sm transition-transform duration-200 hover:-translate-y-1">
                                View Packages
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>