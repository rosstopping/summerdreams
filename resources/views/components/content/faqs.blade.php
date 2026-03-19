<div class="max-w-3xl mx-auto px-6 pb-12">
    <dl class="space-y-6 divide-y divide-gray-200">
        @foreach ($faqs as $faq)
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