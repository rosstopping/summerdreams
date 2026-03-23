<x-layouts.app>
    <x-page-header image="/images/357826990_657385816431795_986628924903999417_n.jpg">
        <x-slot:title>
            Event Calendar
        </x-slot>
        <p>View all our upcoming events in Zante. Browse by month and week to plan your perfect night out.</p>
    </x-page-header>

    {{-- SEO JSON-LD Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EventSchedule",
        "name": "Zante Events Calendar",
        "description": "Complete calendar of Events in Zante",
        "location": {
            "@type": "Place",
            "name": "Zante, Greece"
        }
    }
    </script>

    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-12">
        {{-- Month Selector --}}
        <div class="mb-6 sm:mb-8">
            {{-- Mobile: Stack elements vertically --}}
            <div class="flex flex-col sm:hidden gap-3">
                <h2 class="text-2xl font-bold text-black text-center">
                    {{ $currentDate->format('F Y') }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" 
                       class="flex-1 inline-flex items-center justify-center  bg-black px-4 py-3 font-bold text-white hover:bg-brand transition-all text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden xs:inline">Previous</span>
                        <span class="xs:hidden">Prev</span>
                    </a>
                    <a href="{{ route('calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" 
                       class="flex-1 inline-flex items-center justify-center  bg-black px-4 py-3 font-bold text-white hover:bg-brand transition-all text-sm">
                        <span class="hidden xs:inline">Next</span>
                        <span class="xs:hidden">Next</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            {{-- Desktop: Horizontal layout --}}
            <div class="hidden sm:flex items-center justify-between">
                <a href="{{ route('calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" 
                   class="inline-flex items-center  bg-black px-6 py-3 font-bold text-white hover:bg-brand transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Previous Month
                </a>
                
                <h2 class="text-3xl font-bold text-black">
                    {{ $currentDate->format('F Y') }}
                </h2>
                
                <a href="{{ route('calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" 
                   class="inline-flex items-center  bg-black px-6 py-3 font-bold text-white hover:bg-brand transition-all">
                    Next Month
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Single Week View with Navigation --}}
        <div class="bg-white  sm: shadow-lg p-4 sm:p-8" data-sal="fade" data-sal-duration="500">
            {{-- Week Header with Navigation --}}
            {{-- Mobile: Compact layout --}}
            <div class="mb-4 sm:hidden">
                <h3 class="text-base font-bold text-black text-center mb-3">
                    {{ $currentWeek[0]->format('M j') }} - {{ $currentWeek[6]->format('M j, Y') }}
                </h3>
                <div class="flex gap-2 border-b border-gray-200 pb-3">
                    @if ($prevWeek !== null)
                        <a href="{{ route('calendar', ['month' => $currentDate->month, 'year' => $currentDate->year, 'week' => $prevWeek]) }}" 
                           class="flex-1 inline-flex items-center justify-center text-black hover:text-black/60 transition-all bg-gray-100  py-2 px-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="ml-1 text-sm font-semibold">Prev</span>
                        </a>
                    @else
                        <div class="flex-1 opacity-30 inline-flex items-center justify-center bg-gray-100  py-2 px-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="ml-1 text-sm font-semibold">Prev</span>
                        </div>
                    @endif
                    
                    @if ($nextWeek !== null)
                        <a href="{{ route('calendar', ['month' => $currentDate->month, 'year' => $currentDate->year, 'week' => $nextWeek]) }}" 
                           class="flex-1 inline-flex items-center justify-center text-black hover:text-black/60 transition-all bg-gray-100  py-2 px-3">
                            <span class="mr-1 text-sm font-semibold">Next</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <div class="flex-1 opacity-30 inline-flex items-center justify-center bg-gray-100  py-2 px-3">
                            <span class="mr-1 text-sm font-semibold">Next</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Desktop: Original layout --}}
            <div class="mb-6 hidden sm:flex items-center justify-between border-b border-gray-200 pb-4">
                @if ($prevWeek !== null)
                    <a href="{{ route('calendar', ['month' => $currentDate->month, 'year' => $currentDate->year, 'week' => $prevWeek]) }}" 
                       class="inline-flex items-center text-black hover:text-black/60 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="ml-2 font-semibold">Previous Week</span>
                    </a>
                @else
                    <div class="opacity-0">
                        <span class="ml-2 font-semibold">Previous Week</span>
                    </div>
                @endif
                
                <h3 class="text-xl font-bold text-black">
                    Week of {{ $currentWeek[0]->format('M j') }} - {{ $currentWeek[6]->format('M j, Y') }}
                </h3>
                
                @if ($nextWeek !== null)
                    <a href="{{ route('calendar', ['month' => $currentDate->month, 'year' => $currentDate->year, 'week' => $nextWeek]) }}" 
                       class="inline-flex items-center text-black hover:text-black/60 transition-all">
                        <span class="mr-2 font-semibold">Next Week</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <div class="opacity-0">
                        <span class="mr-2 font-semibold">Next Week</span>
                    </div>
                @endif
            </div>

            {{-- Days Grid --}}
            {{-- Mobile: 2 columns for better readability, Desktop: 7 columns --}}
            <div class="grid grid-cols-2 sm:grid-cols-7 gap-2 sm:gap-4">
                @foreach ($currentWeek as $day)
                    @php
                        $dateKey = $day->format('Y-m-d');
                        $dayEvents = $eventDates[$dateKey] ?? [];
                        $isCurrentMonth = $day->month == $currentDate->month;
                        $isToday = $day->isToday();
                    @endphp
                    
                    <div class="min-h-[180px] sm:min-h-[200px]  border-2 {{ $isToday ? 'border-black bg-brand bg-opacity-10' : ($isCurrentMonth ? 'border-gray-200' : 'border-gray-100 bg-gray-50') }} p-2 sm:p-3">
                        {{-- Day Header --}}
                        <div class="mb-2 text-center">
                            <div class="text-xs font-semibold uppercase text-gray-500">
                                {{ $day->format('D') }}
                            </div>
                            <div class="text-base sm:text-lg font-bold {{ $isToday ? 'text-black' : ($isCurrentMonth ? 'text-black' : 'text-gray-400') }}">
                                {{ $day->format('j') }}
                            </div>
                        </div>

                        {{-- Events --}}
                        @if (count($dayEvents) > 0)
                            <div class="space-y-1.5 sm:space-y-2">
                                @foreach ($dayEvents as $eventData)
                                    <a href="{{ route('calendar.event', ['event' => $eventData['event']->slug, 'date' => $dateKey]) }}" 
                                       class="block  overflow-hidden hover:shadow-lg transition-all active:scale-95"
                                       title="{{ $eventData['event']->name }}">
                                        @if ($eventData['event']->getFirstMedia('images'))
                                            {{ $eventData['event']->getFirstMedia('images')?->img()->attributes([
                                                'alt' => $eventData['event']->name,
                                                'class' => 'w-full h-16 sm:h-20 object-cover',
                                            ]) }}
                                        @else
                                            <div class="w-full h-16 sm:h-20 bg-brand flex items-center justify-center">
                                                <span class="text-white text-xs font-bold text-center px-1">{{ Str::limit($eventData['event']->name, 15) }}</span>
                                            </div>
                                        @endif
                                        <div class="bg-black px-1.5 sm:px-2 py-1">
                                            <p class="text-[10px] sm:text-xs font-semibold text-white text-center leading-tight">
                                                {{ Str::limit($eventData['event']->name, 20) }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- All Events Legend --}}
        @if ($events->count() > 0)
            <div class="mt-8 sm:mt-12 bg-white  sm: shadow-lg p-4 sm:p-8">
                <h3 class="text-xl sm:text-2xl font-bold text-black mb-4 sm:mb-6">Events This Month</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach ($events as $event)
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            @if ($event->getFirstMedia('images'))
                                {{ $event->getFirstMedia('images')?->img()->attributes([
                                    'alt' => $event->name,
                                    'class' => 'h-14 w-14 sm:h-16 sm:w-16 object-cover  flex-shrink-0',
                                ]) }}
                            @else
                                <div class="h-14 w-14 sm:h-16 sm:w-16 bg-brand  flex-shrink-0"></div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="font-bold text-black text-sm sm:text-base truncate">{{ $event->name }}</h4>
                                <a href="{{ $event->calendar_book_link ?: route('book.event', $event->slug) }}" class="text-xs sm:text-sm text-black/60 hover:text-black inline-block mt-0.5">
                                    Book Now →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <x-newsletter></x-newsletter>
</x-layouts.app>
