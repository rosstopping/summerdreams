<div class="relative z-20 px-4">
    <div class="relative grid grid-cols-2 gap-4 md:grid md:grid-cols-4">
        @foreach (data_get($content, 'schedule') as $step)
            <div class="h-60 w-full  bg-white shadow-lg {{ data_get($step, 'attributes.image') ? 'relative overflow-hidden' : 'p-4 md:p-6' }} {{ data_get($step, 'attributes.size') === 'double' ? 'col-span-2' : 'col-span-1' }}">
                <div class="relative z-20 flex h-full flex-col justify-end w-full">
                    <h2 class="text-sm font-bold tracking-threePx uppercase font-sans text-[#7b7b7b] mb-1">{{ data_get($step, 'attributes.time') }}</h2>
                    <p class="w-full text-base font-semibold md:text-xl">{{ data_get($step, 'attributes.title') }}</p>
                </div>
                @if (data_get($step, 'attributes.image'))
                    <div class="absolute top-0 h-full w-full">
                        <div class="absolute left-0 top-0 z-10 h-full w-full bg-black/20"></div>
                        <img data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" alt="{{ data_get($step, 'attributes.title') }}" loading="lazy" width="600" height="433" decoding="async" data-nimg="1" class="h-full w-full object-cover" src="{{ Storage::url(data_get($step, 'attributes.image')) }}">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>