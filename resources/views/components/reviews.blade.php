{{-- reviews --}}
<div class="relative isolate">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<div class="relative px-6 text-center text-black">
			<div class="whitespace-pre text-xs font-bold tracking-widest text-black/60 sm:text-sm uppercase">Don't just take our word for it</div>
			<x-ui.title>Guest Reviews</x-ui.title>
		</div>
		<div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 grid-rows-1 gap-8 text-sm/6 text-gray-900 sm:mt-20 sm:grid-cols-2 xl:mx-0 xl:max-w-none xl:grid-flow-col xl:grid-cols-4">
			<div class="space-y-8 xl:contents xl:space-y-0">
				<div class="space-y-8 xl:row-span-2">
					@foreach ($reviews->skip(0)->take(3) as $review)
						<x-review :review="$review"></x-review>
					@endforeach
				</div>
				<div class="space-y-8 xl:row-start-1">
					@foreach ($reviews->skip(3)->take(3) as $review)
						<x-review :review="$review"></x-review>
					@endforeach
				</div>
			</div>
			<div class="space-y-8 xl:contents xl:space-y-0">
				<div class="space-y-8 xl:row-start-1">
					@foreach ($reviews->skip(6)->take(3) as $review)
						<x-review :review="$review"></x-review>
					@endforeach
				</div>
				<div class="space-y-8 xl:row-span-2">
					@foreach ($reviews->skip(9)->take(3) as $review)
						<x-review :review="$review"></x-review>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>