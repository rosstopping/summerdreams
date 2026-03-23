<section class="py-12">
    <div class="container mx-auto px-6 flex flex-wrap md:flex-nowrap justify-between gap-24">
        <div class="w-full md:w-5/12 py-12 md:py-20">
            <div class="text-black">
                <x-ui.title>{{ data_get($content, 'title') }}</x-ui.title>
            </div>
            <div data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="prose text-gray-700 mt-8 text-lg max-w-none leading-relaxed">
                {!! data_get($content, 'content') !!}
            </div>
            @if (data_get($content, 'button_text'))
                <div data-sal="slide-up" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="mt-10 flex gap-4 flex-wrap">
                    <a class="inline-block bg-brand hover:bg-brand-dark font-black text-white rounded-xl border-3 border-black px-8 py-4 shadow-[4px_4px_0px_rgba(0,0,0,0.15)] hover:shadow-[6px_6px_0px_rgba(0,0,0,0.2)] transition-all uppercase text-sm tracking-tight" href="{{ data_get($content, 'button_link') }}">{{ data_get($content, 'button_text') }}</a>
                    @if (data_get($content, 'button_two_text'))
                        <a class="inline-block bg-white font-black text-gray-900 rounded-xl border-3 border-black px-8 py-4 shadow-[4px_4px_0px_rgba(0,0,0,0.15)] hover:shadow-[6px_6px_0px_rgba(0,0,0,0.2)] hover:bg-gray-50 transition-all uppercase text-sm tracking-tight" href="{{ data_get($content, 'button_two_link') }}">{{ data_get($content, 'button_two_text') }}</a>
                    @endif
                </div>
            @endif
        </div>
        <div class="w-full md:flex-1 relative md:py-6 md:order-first">
            @if (data_get($content, 'image'))
                <div class="relative overflow-hidden rounded-3xl border-4 border-black shadow-[8px_8px_0px_rgba(0,0,0,0.1)]" data-sal="slide-left" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out">
                    <img alt="{{ data_get($content, 'title') }}"  class="h-auto md:h-full w-full object-cover object-top" src="{{ Storage::url(data_get($content, 'image')) }}" />
                </div>
            @endif
        </div>
    </div>
</section>