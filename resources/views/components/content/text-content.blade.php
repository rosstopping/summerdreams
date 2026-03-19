<div class="py-12 @if (data_get($content, 'content')) md:py-20 @endif">
    <div class="relative px-6 text-center">
        @if (data_get($content, 'eyebrow'))
            <div data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="whitespace-pre text-xs font-bold tracking-widest text-black/60 sm:text-sm uppercase">{{ data_get($content, 'eyebrow') }}</div>
        @endif
        @if (data_get($content, 'title'))
        <div class="max-w-3xl mx-auto">
            <x-ui.title>{{ data_get($content, 'title') }}</x-ui.title>
        </div>
        @endif
    </div>
    @if (data_get($content, 'content'))
        <div data-aos="fade" data-aos-delay="300" data-aos-duration="1000" data-aos-easing="ease-in-out" class="mt-12 max-w-xl mx-auto px-6 prose text-black/60 text-lg text-center leading-relaxed relative z-20">
            {!! data_get($content, 'content') !!}
        </div>
    @endif
</div>