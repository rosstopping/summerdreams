<div class="transition-all ease-out duration-500 relative">
    <div>
        <div class="relative w-full pt-58 pb-24 rounded-none lg:overflow-hidden">
            <div class="container mx-auto px-6 relative z-40">
                <h1 class="text-black text-4xl lg:text-7xl sm:text-5xl text-4.5xl font-black leading-10 md:leading-normal font-display z-20 md:max-w-full md:px-0 tracking-wide mx-auto text-center font-heading"><span class="bg-gradient-to-b from-brand to-brand-dark text-white px-6 py-2">{{ data_get($content, 'title') }}<span></h1>
                <div class="relative z-30 text-lg md:text-2xl mt-6">
                    <div class="max-w-[460px] text-white md:max-w-xl mx-auto !text-center">{!! data_get($content, 'description') !!}</div>
                </div>
            </div>
            <div x-data="slideshow({{ $content->getMedia('images')->count() }})" class="absolute inset-0 w-full h-full bg-black">
                @foreach ($content->getMedia('images') as $slide)
                    {{
                        $slide->img()->attributes([
                            'alt' => 'VVIP Sunset Yacht Party '. $slide->name,
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
            <div class="opacity-50 absolute inset-0 w-ful h-full bg-linear-to-t from-black"></div>
        </div>
    </div>
</div>