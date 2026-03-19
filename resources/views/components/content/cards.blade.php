<div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto mt-16 grid grid-cols-1 gap-x-8 gap-y-20 @if (count(data_get($content, 'cards')) === 3) lg:grid-cols-3 max-w-2xl lg:max-w-none @endif @if (count(data_get($content, 'cards')) === 2) lg:grid-cols-2 max-w-3xl @endif">
        @foreach (data_get($content, 'cards') as $card)
            <article class="flex flex-col items-start justify-between">
                @if (data_get($card, 'attributes.image'))
                    <div class="relative w-full">
                        <img alt="{{ data_get($card, 'attributes.title') }}" src="{{ Storage::url(data_get($card, 'attributes.image')) }}" class="aspect-16/9 w-full  bg-gray-100 object-cover sm:aspect-2/1 lg:aspect-3/2" />
                    </div>
                @endif
                <div class="max-w-xl flex-1">
                    <div class="mt-8 group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                            {{ data_get($card, 'attributes.title') }}
                        </h3>
                        <div class="mt-5 prose">{!! data_get($card, 'attributes.content') !!}</div>
                    </div>
                </div>
                @if (data_get($card, 'attributes.button_text'))
                <div data-sal="slide-up" data-sal-duration="1005000" data-sal-easing="ease-in-out" class="mt-6">
                    <a class="inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-8 py-3" href="{{ data_get($card, 'attributes.button_link') }}">{{ data_get($card, 'attributes.button_text') }}</a>
                </div>
                @endif
            </article>
        @endforeach
    </div>
</div>