<x-layouts.app>
    <x-page-header image="/images/zante event packages 26.jpg">
        <x-slot:title>
            {{ $page->title }}
        </x-slot>
    </x-page-header>

    <div class="pb-12">
        @if ($page?->content)
            @foreach ($page->flexibleContent as $content)
                <x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
            @endforeach
        @endif
    </div>
    
    @if (session('booking_site') !== 'zec')
        <x-newsletter></x-newsletter>
    @endif
</x-layouts.app>
