<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="/images/357826990_657385816431795_986628924903999417_n.webp">
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
    <x-newsletter></x-newsletter>
</x-layouts.app>
