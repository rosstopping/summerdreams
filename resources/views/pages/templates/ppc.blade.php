<x-layouts.blank>
    {{-- <x-header></x-header> --}}
    @if ($page?->content)
		@foreach ($page->flexibleContent as $content)
			<x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
		@endforeach
	@endif
    {{-- <x-footer></x-footer> --}}
</x-layouts.blank>
