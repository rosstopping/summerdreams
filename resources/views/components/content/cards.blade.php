@php
    $cardCount = count(data_get($content, 'cards', []));
    $gridLayoutClasses = match ($cardCount) {
        3 => 'lg:grid-cols-3 max-w-2xl lg:max-w-none',
        2 => 'lg:grid-cols-2 max-w-3xl',
        default => '',
    };
@endphp

<div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto mt-16 grid grid-cols-1 gap-8 {{ $gridLayoutClasses }}">
        @foreach (data_get($content, 'cards') as $card)
            <article class="group flex flex-col items-start justify-between overflow-hidden rounded-3xl border-4 border-black bg-white shadow-[8px_8px_0px_rgba(0,0,0,0.1)] transition-all duration-300 hover:shadow-[12px_12px_0px_rgba(0,0,0,0.16)]">
                @if (data_get($card, 'attributes.image'))
                    <div class="relative w-full overflow-hidden border-b-4 border-black bg-gray-100">
                        <img alt="{{ data_get($card, 'attributes.title') }}" src="{{ Storage::url(data_get($card, 'attributes.image')) }}" class="aspect-16/9 w-full bg-gray-100 object-cover transition-transform duration-300 group-hover:scale-105 sm:aspect-2/1 lg:aspect-3/2" />
                    </div>
                @endif
                <div class="flex max-w-xl flex-1 flex-col p-8">
                    <div class="relative flex-1">
                        <h3 class="text-xl font-black uppercase leading-tight tracking-tight text-gray-900 transition-colors group-hover:text-brand">
                            {{ data_get($card, 'attributes.title') }}
                        </h3>
                        <div class="prose mt-4 max-w-none text-gray-700">{!! data_get($card, 'attributes.content') !!}</div>
                    </div>
                    @if (data_get($card, 'attributes.button_text'))
                    <div data-sal="slide-up" data-sal-duration="1005000" data-sal-easing="ease-in-out" class="mt-8 border-t-4 border-black pt-6">
                        <a class="inline-block rounded-xl border-3 border-black bg-brand hover:bg-brand-dark px-8 py-3 text-sm font-black uppercase tracking-tight text-black shadow-[4px_4px_0px_rgba(0,0,0,0.15)] transition-all  hover:shadow-[6px_6px_0px_rgba(0,0,0,0.2)]" href="{{ data_get($card, 'attributes.button_link') }}">{{ data_get($card, 'attributes.button_text') }}</a>
                    </div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</div>