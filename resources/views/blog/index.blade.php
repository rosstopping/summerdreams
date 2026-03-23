<x-layouts.app>
    <x-page-header image="/images/zante event packages 26.jpg">
        <x-slot:title>
            Zante Nightlife Guides
            </x-slot>
            <p>Enjoy our very comprehensive Zante Nightlife guides, where we share over 10 years of experience and knowledge of how to make the most of your Zante holiday.</p>
    </x-page-header>
    <div class="pt-12 pb-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <a href="{{ $post->slug }}">
                                {{ $post->getFirstMedia('featured_image')?->img()->attributes([
                                    'alt' => $post->title,
                                    'class' => 'aspect-16/9 w-full  bg-gray-100 object-cover sm:aspect-2/1 lg:aspect-3/2',
                                ]) }}
                            </a>
                            {{-- <div class="absolute inset-0  ring-1 ring-inset ring-gray-900/10"></div> --}}
                        </div>
                        <div class="max-w-xl flex-1">
                            <div class="mt-8 group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{ $post->slug }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ $post->excerpt }}</p>
                            </div>
                        </div>
                        <div data-sal="slide-up" data-sal-duration="1005000" data-sal-easing="ease-in-out" class="mt-6">
                            <a class="inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-8 py-3" href="{{ $post->slug }}">Read more</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
