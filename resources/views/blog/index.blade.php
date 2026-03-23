<x-layouts.app>
    <x-page-header image="/images/events/vice-parties/IMG_5777.jpg">
        <x-slot:title>
            Summer Guides
            </x-slot>
            <p>Enjoy our very comprehensive Summer Guides, where we share over 10 years of experience and knowledge of how to make the most of your summer holiday.</p>
    </x-page-header>
    <div class="relative py-20 sm:py-28 ">
        <!-- Decorative shapes -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-32 -mt-32"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-15 -mr-32 -mb-32"></div>

        <div class="mx-auto max-w-7xl px-6 lg:px-8 relative z-10">
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="group flex flex-col items-start justify-between bg-white rounded-3xl border-4 border-black overflow-hidden shadow-[6px_6px_0px_rgba(0,0,0,0.1)] hover:shadow-[10px_10px_0px_rgba(0,0,0,0.15)] transition-all duration-300">
                        <div class="relative w-full h-56 overflow-hidden bg-gray-100">
                            <a href="{{ $post->slug }}" class="block w-full h-full">
                                {{ $post->getFirstMedia('featured_image')?->img()->attributes([
                                    'alt' => $post->title,
                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
                                ]) }}
                            </a>
                        </div>
                        <div class="max-w-xl flex-1 p-8 flex flex-col">
                            <div class="group/link relative flex-1">
                                <h3 class="text-xl font-black leading-snug text-gray-900 group-hover/link:text-brand transition-colors">
                                    <a href="{{ $post->slug }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600">{{ $post->excerpt }}</p>
                            </div>
                            <div class="mt-6 pt-6 border-t-3 border-gray-100">
                                <a class="inline-block bg-brand hover:bg-brand-dark font-black text-black rounded-xl border-3 border-black px-6 py-3 shadow-[4px_4px_0px_rgba(0,0,0,0.15)] hover:shadow-[6px_6px_0px_rgba(0,0,0,0.2)] transition-all uppercase text-sm tracking-tight" href="{{ $post->slug }}">Read more</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
