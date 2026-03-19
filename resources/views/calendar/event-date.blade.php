<x-layouts.app>
    @php
        $eventImage = $event->getFirstMedia('images');
    @endphp

    <x-page-header image="{{ $eventImage ? $eventImage->getUrl() : Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
            {{ $event->name }}
        </x-slot>
        <p>{{ $eventDate->format('l, F j, Y') }}</p>
    </x-page-header>

    {{-- SEO JSON-LD Schema for Event --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": @json($event->name),
        "url": "{{ url('/calendar/event/' . $event->slug . '/' . $eventDate->format('Y-m-d')) }}",
        "startDate": "{{ $eventDate->copy()->setTime(20, 0)->toIso8601String() }}",
        "endDate": "{{ $eventDate->copy()->setTime(6, 0)->addDay()->toIso8601String() }}",
        "description": @json(Str::limit(strip_tags($event->description ?? ''), 160)),
        @if ($eventImage)
        "image": "{{ $eventImage->getUrl() }}",
        @endif
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "eventStatus": "https://schema.org/EventScheduled",
        "location": {
            "@type": "Place",
            "name": "Zante, Greece",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Zante",
                "addressCountry": "GR"
            }
        },
        "offers": {
            "@type": "Offer",
            "url": "{{ $event->calendar_book_link ?: route('book.event', $event->slug) }}",
            "price": {{ $event->amount }},
            "priceCurrency": "{{ $event->currency->value ?? 'EUR' }}",
            "availability": "https://schema.org/InStock",
            "validFrom": "{{ now()->toIso8601String() }}"
        },
        "organizer": {
            "@type": "Organization",
            "name": "VVip Events Zante",
            "url": "{{ url('/') }}",
            "sameAs": [
                "https://www.facebook.com/vvipzante",
                "https://www.instagram.com/vvipzante"
            ]
        }
    }
    </script>

    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-12">
        {{-- Back Button --}}
        <div class="mb-6 sm:mb-8">
            <a href="{{ route('calendar') }}" 
               class="inline-flex items-center text-black/60 hover:text-black font-semibold text-sm sm:text-base py-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Calendar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-12">
            {{-- Event Image --}}
            <div data-sal="fade" data-sal-duration="1000">
                @if ($eventImage)
                    {{ $eventImage->img()->attributes([
                        'alt' => $event->name,
                        'class' => 'w-full h-[300px] sm:h-[400px] lg:h-[500px] object-cover  sm: shadow-lg',
                    ]) }}
                @else
                    <div class="w-full h-[300px] sm:h-[400px] lg:h-[500px] bg-brand  sm: shadow-lg flex items-center justify-center px-4">
                        <span class="text-white text-xl sm:text-2xl font-bold text-center">{{ $event->name }}</span>
                    </div>
                @endif
            </div>

            {{-- Event Details --}}
            <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200">
                <div class="bg-white  sm: shadow-lg p-5 sm:p-8">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-black mb-3 sm:mb-4">{{ $event->name }}</h1>
                    
                    {{-- Date & Time --}}
                    <div class="mb-4 sm:mb-6 space-y-2">
                        <div class="flex items-center text-black/80">
                            <svg class="w-5 h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold text-sm sm:text-base">{{ $eventDate->format('l, F j, Y') }}</span>
                        </div>
                    </div>

                    {{-- Price --}}
                    @if ($event->amount)
                        <div class="mb-5 sm:mb-6 pb-5 sm:pb-6 border-b border-gray-200">
                            <div class="text-2xl sm:text-3xl font-bold text-black">
                                {{ format_currency($event->amount, $event->currency) }}
                            </div>
                            @if ($event->deposit)
                                <div class="text-xs sm:text-sm text-black/60 mt-1">
                                    Deposit: {{ format_currency($event->deposit, $event->currency) }}
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Description --}}
                    @if ($event->description)
                        <div class="prose prose-sm sm:prose-lg max-w-none text-black/80 mb-6 sm:mb-8">
                            {!! $event->description !!}
                        </div>
                    @endif

                    {{-- Book Button --}}
                    <div class="space-y-3 sm:space-y-4">
                        <a href="{{ $event->calendar_book_link ?: route('book.event', $event->slug) }}" 
                           class="block w-full text-center  bg-black px-6 sm:px-8 py-3 sm:py-4 font-bold text-white hover:bg-brand transition-all text-base sm:text-lg active:scale-95">
                            Book {{ $event->name }}
                        </a>
                        
                        <a href="{{ route('calendar') }}" 
                           class="block w-full text-center  border-2 border-black px-6 sm:px-8 py-3 sm:py-4 font-bold text-black hover:bg-black hover:text-white transition-all text-sm sm:text-base active:scale-95">
                            View More Dates
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Images --}}
        @if ($event->getMedia('images')->count() > 1)
            <div class="mt-8 sm:mt-12">
                <h3 class="text-xl sm:text-2xl font-bold text-black mb-4 sm:mb-6">Gallery</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6">
                    @foreach ($event->getMedia('images')->skip(1) as $image)
                        <div class="relative h-40 sm:h-48 md:h-64" data-sal="fade" data-sal-delay="{{ $loop->index * 100 }}">
                            {{ $image->img()->attributes([
                                'class' => 'h-full w-full object-cover  sm:',
                            ]) }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-newsletter></x-newsletter>
</x-layouts.app>
