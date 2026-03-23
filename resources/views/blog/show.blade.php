<x-layouts.app>
    <x-page-header image="{{ $post->getFirstMedia('featured_image')->getFullUrl() ?? '/images/events/vice-parties/IMG_5777.jpg' }}">
        <x-slot:title>
            {{ $post->title }}
            </x-slot>
            {{-- <p>Enjoy our very comprehensive Zante Nightlife guides, where we share over 10 years of experience and knowledge of how to make the most of your Zante holiday.</p> --}}
    </x-page-header>
    <div class="pb-12">
        @if ($post?->flexibleContent)
            @foreach ($post->flexibleContent as $content)
                <x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
            @endforeach
        @endif
    </div>
    <div class="container mx-auto px-6 pt-12 pb-24">
        <div class="prose max-w-5xl mx-auto">
            {!! $post->content !!}
        </div>
    </div>
    
    <x-newsletter></x-newsletter>
</x-layouts.app>
