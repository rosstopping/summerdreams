<x-layouts.app>
    <x-page-header :responsiveImage="$page?->image('header')" image="/images/357826990_657385816431795_986628924903999417_n.jpg">
        <x-slot:title>
        {{ $page?->title }}
        </x-slot>
        {!! $page?->description !!}
    </x-page-header>

    <!-- Hero Section with Playful Background -->
    <div class="relative overflow-hidden bg-gradient-to-br from-yellow-50 via-pink-50 to-blue-50 py-20 sm:py-28">
        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-32 -mb-32"></div>

        <div class="relative mx-auto max-w-7xl px-6 sm:px-8 text-center">
            <h1 class="text-5xl sm:text-6xl font-black uppercase tracking-tight text-gray-900 leading-none mb-6">
                Got Questions?
            </h1>
            <p class="text-xl sm:text-2xl text-gray-700 max-w-2xl mx-auto mb-8 font-medium">
                We've got answers. Find everything you need to know about Summer Dreams.
            </p>
            <p class="text-base text-gray-600">
                Can't find what you're looking for? <a href="/contact" class="font-bold text-pink-600 hover:text-pink-700 underline decoration-2">Get in touch with us</a>
            </p>
        </div>
    </div>

    <!-- Featured FAQs Grid -->
    <div class="mx-auto max-w-7xl px-6 sm:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($faqs->take(4) as $faq)
            <div class="group bg-white rounded-3xl border-4 border-black p-8 sm:p-10 shadow-[8px_8px_0px_rgba(0,0,0,0.1)] hover:shadow-[12px_12px_0px_rgba(0,0,0,0.15)] transition-all duration-300 overflow-hidden relative">
                <!-- Accent corner -->
                <div class="absolute -top-1 -right-1 w-20 h-20 bg-pink-400 rounded-bl-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="relative z-10">
                    <dt class="text-xl sm:text-2xl font-black uppercase text-gray-900 mb-4 leading-tight">{{ $faq->question }}</dt>
                    <dd class="text-base text-gray-700 leading-relaxed prose prose-sm max-w-none">
                        {!! $faq->answer !!}
                    </dd>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Accordion Section -->
    <div class="mx-auto max-w-4xl px-6 sm:px-8 py-12 pb-20">
        <div class="space-y-4">
            @foreach ($faqs->skip(4) as $faq)
                <div x-data="{ open: false }" class="group bg-white rounded-2xl border-3 border-black overflow-hidden shadow-[6px_6px_0px_rgba(0,0,0,0.1)] hover:shadow-[8px_8px_0px_rgba(0,0,0,0.15)] transition-all duration-300">
                    <dt class="text-lg">
                        <button type="button" class="w-full flex justify-between items-center p-6 sm:p-8 text-left bg-white group-hover:bg-yellow-50 transition-colors duration-300" @click="open = !open" :aria-expanded="open.toString()">
                            <span class="font-black text-lg sm:text-xl text-gray-900 uppercase tracking-tight pr-4">{{ $faq->question }}</span>
                            <span class="flex-shrink-0 h-8 w-8 flex items-center justify-center">
                                <svg class="h-6 w-6 text-pink-600 font-black transition-transform duration-300" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </span>
                        </button>
                    </dt>
                    <dd x-show="open" x-transition class="px-6 sm:px-8 pb-6 sm:pb-8 bg-white border-t-3 border-gray-100">
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                            {!! $faq->answer !!}
                        </div>
                    </dd>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Banner -->
    <div class="relative mx-auto max-w-7xl px-6 sm:px-8 mb-20">
        <div class="relative overflow-hidden bg-gradient-to-r from-pink-400 to-pink-500 rounded-3xl p-12 sm:p-16 shadow-xl">
            <div class="absolute top-0 right-0 w-40 h-40 bg-yellow-300 rounded-full mix-blend-screen opacity-30 -mr-20 -mt-20"></div>
            <div class="relative z-10 text-center">
                <h3 class="text-3xl sm:text-4xl font-black uppercase text-white mb-4">Still have questions?</h3>
                <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Our team is ready to help. Reach out anytime and we'll get back to you faster than you can say "summer vibes."</p>
                <a href="/contact" class="inline-block bg-white text-pink-600 font-black text-lg px-8 py-4 rounded-full border-4 border-white hover:bg-pink-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
    <x-newsletter></x-newsletter>
</x-layouts.app>
