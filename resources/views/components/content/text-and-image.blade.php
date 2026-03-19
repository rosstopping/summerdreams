<section class="py-12">
    <div class="container mx-auto px-6 flex flex-wrap md:flex-nowrap justify-between gap-24">
        <div class="w-full md:w-5/12 py-12 md:py-20">
            <div class="text-black">
                <x-ui.title>{{ data_get($content, 'title') }}</x-ui.title>
            </div>
            <div data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="prose text-black/60 mt-12 text-lg max-w-none">
                {!! data_get($content, 'content') !!}
            </div>
            @if (data_get($content, 'button_text'))
                <div data-sal="slide-up" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="mt-6 flex gap-2">
                    <a class="inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-8 py-3" href="{{ data_get($content, 'button_link') }}">{{ data_get($content, 'button_text') }}</a>
                    @if (data_get($content, 'button_two_text'))
                        <a class="inline-block  bg-brand font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-8 py-3" href="{{ data_get($content, 'button_two_link') }}">{{ data_get($content, 'button_two_text') }}</a>
                    @endif
                </div>
            @endif
        </div>
        <div class="w-full md:flex-1 relative md:py-6">
            @if (data_get($content, 'image'))
                <img alt="{{ data_get($content, 'title') }}" data-sal="slide-right" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="h-auto md:h-full w-full  md:absolute inset-0 object-cover object-top" src="{{ Storage::url(data_get($content, 'image')) }}" />
            @endif
        </div>
    </div>
</section>