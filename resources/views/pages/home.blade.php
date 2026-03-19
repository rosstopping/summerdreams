<x-layouts.app>
    <div class="pb-12">
        @if ($page?->content)
            @foreach ($page->flexibleContent as $content)
                <x-dynamic-component :component="'content.' . $content->name()" :content="$content"></x-dynamic-component>
            @endforeach
        @endif
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
