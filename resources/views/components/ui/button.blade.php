<a class="
	inline-block  bg-white font-bold text-gray-950 hover:bg-white hover:bg-brand hover:text-white hover:shadow-xl transition-all ease-in-out
	@if ($size == 'md') px-6 py-3
	@elseif ($size == 'sm') px-5 py-3 text-sm
	@elseif ($size == 'sm') px-4 py-1 text-xs
	@else px-8 py-3
	@endif
" href="{{ $href }}">{{ $slot }}</a>