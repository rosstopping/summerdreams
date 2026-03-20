<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="pb-12">
        @if ($page?->content)
            @foreach ($page->flexibleContent as $content)
                <x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
            @endforeach
        @endif
    </div>
    @foreach (\App\Models\Event::where('hidden', false)->orderBy('created_at')->get() as $event)
        <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-y-12 lg:gap-y-12 gap-x-24">
            <div>
                {{-- <h4 data-sal="fade" data-sal-delay="300" data-sal-duration="1000" data-sal-easing="ease-in-out" class="whitespace-pre text-xs font-bold tracking-widest text-black/60 sm:text-sm uppercase">Now 95% sold out for Summer 2023 – BOOK NOW!</h4> --}}
                <div class="text-black">
                    <x-ui.title>{{ $event->name }}</x-ui.title>
                </div>
                <div data-sal="fade" data-sal-duration="500" data-sal-easing="ease-in-out" class="mt-12 prose text-black/60 max-w-none">
                    {!! $event->description !!}
                </div>
                <div data-sal="slide-up" data-sal-duration="1000" data-sal-easing="ease-in-out" class="mt-6">
                    <a class="inline-block bg-black font-bold text-white border-2 border-black hover:bg-brand hover:text-white hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all ease-in-out px-8 py-3 uppercase" href="/book">Book {{ $event->name }}</a>
                </div>
            </div>
            <div>
                {{ $event->getFirstMedia('images')?->img()->attributes([
                    'alt' => $event->name,
                    'class' => 'h-64 lg:h-full w-full object-cover ',
                    'data-sal' => 'slide-right',
                    'data-sal-duration' => '1000',
                    'data-sal-easing' => 'ease-in-out',
                ]) }}
            </div>
        </div>
        <div class="grid grid-cols-4 gap-6 container mx-auto px-6 py-12 lg:py-24">
            @foreach ($event->getMedia('images')->skip(1) as $image)
                <div class="relative h-96">
                    {{ $image?->img()->attributes([
                        'class' => 'h-full w-full object-cover ',
                        'data-sal' => 'slide-up',
                        'data-sal-delay' => $loop->index * 200,
                        'data-sal-duration' => '500',
                        'data-sal-easing' => 'ease-in-out',
                    ]) }}
                </div>
            @endforeach
        </div>
    @endforeach
    <x-newsletter></x-newsletter>
</x-layouts.app>
