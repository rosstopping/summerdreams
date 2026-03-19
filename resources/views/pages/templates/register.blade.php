<x-layouts.app>
    <div class="relative bg-black pt-32 pb-12 w-screen min-h-screen overflow-hidden transition-all ease-in-out z-50 flex justify-center items-center">

        {{ $page?->image('header')?->img()->attributes([
            'class' => 'absolute inset-0 w-full h-full object-cover opacity-25',
        ]) }}
                    
        <div class="absolute top-0 left-0 w-full flex justify-center items-center pt-12 z-10">
            <img class="h-20" src="{{ Vite::asset('resources/images/logo.webp') }}" />
        </div>

        <div class="relative z-10 px-6">

            <div class="max-w-2xl mx-auto mt-12">
                <div class="text-center max-w-sm mx-auto text-white">
                    <x-ui.title>{{ $page?->title }}</x-ui.title>
                </div>

                <div data-sal="slide-up"
                data-sal-delay="100"
                data-sal-duration="1000"
                data-sal-easing="ease-out" class="prose prose-lg text-white leading-tight mt-12">
                    {!! $page?->description !!}
                </div>

                <div class="mt-12 flex justify-center">
                    <x-ui.button href="#register">Register now</x-ui.button>
                </div>
            </div>
        </div>
    </div>

    <div id="register" class="pt-12 pb-12">
        @if ($page?->content)
            @foreach ($page->flexibleContent as $content)
                <x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
            @endforeach
        @endif
    </div>
</x-layouts.app>
