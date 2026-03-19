<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>
    <div class="">
        <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24">
            <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">Frequently asked questions</h2>
            <p class="mt-6 max-w-2xl text-base leading-7 text-gray-600">Have a different question and can’t find the answer you’re looking for? Reach out to our support team by <a href="/contact" class="font-semibold text-indigo-600 hover:text-indigo-500">sending us an email</a> and we’ll get back to you as soon as we can.</p>
            <div class="mt-20">
                <dl class="space-y-16 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-16 sm:space-y-0 lg:gap-x-10">
                    @foreach ($faqs->take(4) as $faq)
                    <div>
                        <dt class="text-base font-semibold leading-7 text-gray-900">{{ $faq->question }}</dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600 prose max-w-none">{!! $faq->answer !!}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-6 pb-12">
        <dl class="space-y-6 divide-y divide-gray-200">
            @foreach ($faqs->skip(4) as $faq)
                <div x-data="{ open: false }" class="pt-6">
                    <dt class="text-lg">
                        <button type="button" class="text-left w-full flex justify-between items-start text-gray-400" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()">
                            <span class="font-medium text-gray-900">{{ $faq->question }}</span>
                            <span class="ml-6 h-7 flex items-center">
                                <svg class="h-6 w-6 transform -rotate-180" x-description="" x-state:on="Open" x-state:off="Closed" :class="{ '-rotate-180': open, 'rotate-0': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                    </dt>
                    <dd class="mt-2 pr-12" x-show="open">
                        <div class="prose text-base text-gray-500 max-w-none">
                            {!! $faq->answer !!}
                        </div>
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
