<figure data-sal="slide-up"
data-sal-delay="100"
data-sal-duration="1000"
data-sal-easing="ease-out" class=" bg-white ring-1 shadow-lg ring-gray-900/5 overflow-hidden">
    {{ $review->getFirstMedia('featured_image')?->img()->attributes([
        'alt' => $review->name,
        'class' => 'w-full h-auto rounded-t-xl bg-gray-50',
    ]) }}
    <div class="p-6">
        <blockquote class="text-gray-900">
            <p>“{{ $review->content }}”</p>
        </blockquote>
        <figcaption class="mt-6 flex items-center gap-x-4">
            <div>
                <div class="font-semibold">{{ $review->name }}</div>
                {{-- <div class="text-gray-600">@lindsaywalton</div> --}}
            </div>
        </figcaption>
    </div>
</figure>