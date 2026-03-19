<div class="mx-auto max-w-7xl px-6 lg:px-8 pb-24">
    <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @foreach ($events as $event)
            <article class="flex flex-col items-start">
                <div class="relative w-full">
                    <a href="{{ route('book.event', $event) }}">
                        {{ $event->getFirstMedia('images')?->img()->attributes([
                            'alt' => $event->name,
                            'class' => 'aspect-16/9 w-full  bg-gray-100 object-cover sm:aspect-2/1 lg:aspect-3/2',
                        ]) }}
                    </a>
                </div>
                <div class="max-w-xl">
                    <div class="mt-8 group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                            <a href="{{ route('book.event', $event) }}">
                                {{ $event->name }}
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ Str::of(strip_tags($event->description))->before('.')->limit(250) }}.</p>
                        <div data-sal="slide-up" data-sal-duration="500" data-sal-easing="ease-in-out" class="mt-6">
                            <a class="inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-6 py-2 text-sm" href="{{ route('book.event', $event) }}">Purchase Tickets (@currency($event->currency->value){{ $event->amount }})</a>
                        </div>

                        @if ($event->upgrade)
                            <h3 class="mt-8 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                <a href="{{ route('book.event', [$event, 'upgrade' => $event->upgrade->id]) }}">
                                    {{ $event->upgrade->title }} Upgrade
                                </a>
                            </h3>
                            @if ($event->upgrade->includes)
                            <ul role="list" class="mt-6 space-y-3 text-sm leading-6 text-gray-600 ">
                                @foreach ($event->upgrade->includes as $include)
                                <li class="flex gap-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5 text-brand">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                        
                                    {{ data_get($include, 'fields.description') }}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        
                        <div data-sal="slide-up" data-sal-duration="500" data-sal-easing="ease-in-out" class="mt-6">
                            <a class="inline-block  bg-brand font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-6 py-2 text-sm" href="{{ route('book.event', [$event, 'upgrade' => $event->upgrade->id]) }}">Purchase {{ $event->upgrade->title }} Tickets (@currency($event->currency->value){{ $event->amount + $event->upgrade->amount }})</a>
                        </div>
                    @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>