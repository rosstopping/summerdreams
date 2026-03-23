<x-layouts.app>
    <x-page-header image="/images/zante event packages 2026.jpg">
        <x-slot:title>
            Welcome, {{ $booking->name }}
        </x-slot>
        {{-- Lorem ipsum dolor, sit amet consectetur adipisicing elit. --}}
    </x-page-header>

    {{-- <div class="bg-gray-100 pt-12">
        <nav class="max-w-6xl mx-auto px-6 flex space-x-4">
            <a href="/account" class="{{ Request::path() === 'account' ? 'bg-white text-gray-700' : 'text-gray-500 hover:text-gray-700' }}  px-3 py-2 text-sm font-medium">Booking Overview</a>
            <a href="/account/checkin" class="{{ Request::path() === 'account/checkin' ? 'bg-white text-gray-700' : 'text-gray-500 hover:text-gray-700' }}  px-3 py-2 text-sm font-medium">Check-in Online</a>
            <a href="/account/faqs" class="{{ Request::path() === 'account/faqs' ? 'bg-white text-gray-700' : 'text-gray-500 hover:text-gray-700' }}  px-3 py-2 text-sm font-medium">FAQs</a>
            <a href="/account/customer-services" class="{{ Request::path() === 'account/customer-services' ? 'bg-white text-gray-700' : 'text-gray-500 hover:text-gray-700' }}  px-3 py-2 text-sm font-medium">Customer Services</a>
        </nav>
    </div> --}}

    <div class="px-6 py-6 md:py-12 relative z-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Booking Overview</h2>
                <a href="/logout" class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>

                    <span class="text-sm">Logout</span>
                </a>
            </div>
            <div class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Card -->
                <div class="overflow-hidden bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <svg class="h-6 w-6 text-gray-400" x-description="Heroicon name: outline/scale"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Guests</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">{{ $booking->guests }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-cyan-700 hover:text-cyan-900">Add guests</a>
                        </div>
                    </div> --}}
                </div>
                <div class="overflow-hidden bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <svg class="h-6 w-6 text-gray-400" x-description="Heroicon name: outline/arrow-path"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.121 7.629A3 3 0 009.017 9.43c-.023.212-.002.425.028.636l.506 3.541a4.5 4.5 0 01-.43 2.65L9 16.5l1.539-.513a2.25 2.25 0 011.422 0l.655.218a2.25 2.25 0 001.718-.122L15 15.75M8.25 12H12m9 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total cost</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            &pound;{{ number_format($booking->amount, 2) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-cyan-700 hover:text-cyan-900"></a>
                        </div>
                    </div> --}}
                </div>
                <div class="overflow-hidden bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <svg class="h-6 w-6 text-gray-400" x-description="Heroicon name: outline/check-circle"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Balance</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">&pound;{{ $booking->balance }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-cyan-700 hover:text-cyan-900">View payments</a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="overflow-hidden bg-white shadow-sm sm: mt-6">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Booking Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Booking details and personal information.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Package</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if ($booking->packages->count() > 0)
                                    {{ $booking->packages->pluck('name')->implode(',') }}
                                @endif
                                @if ($booking->events->count() > 0)
                                    {{ $booking->events->pluck('name')->implode(',') }}
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Arrival Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ data_get($booking, 'arrival_date')->format('jS F Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Guests</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->guests }}</dd>
                        </div>
                    </dl>
                    @if ($booking->extras->count() > 0)
                        <div class="mt-6 space-y-4">
                            @foreach ($booking->extras as $extra)
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">

                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Extra</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $extra->name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ data_get($extra->pivot, 'date')?->format('jS F Y') ?: '-' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Guests</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $extra->pivot->quantity ?: '-' }}
                                        </dd>
                                    </div>
                                </dl>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if ($booking->balancing_payment_amount_without_formatting > 0)
                <div class="overflow-hidden bg-white shadow-sm sm: mt-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Confirm your events</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">As per our terms and conditions, in order to guarantee your White Party tickets we require that 50% of your balance is paid before you leave.</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <div>
                            <form method="POST" action="{{ route('pay-balance') }}">
                                @csrf
                                <button
                                    class="inline-block bg-black font-bold text-white border-2 border-black hover:bg-brand hover:text-white hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all ease-in-out px-6 py-3 text-sm uppercase">MAKE
                                    PAYMENT (&pound;{{ $booking->balancing_payment_amount }})</button>
                            </form>
                            {{-- <div class="prose text-xs italic mt-2">
                                <p>*At least half of your booking total must be paid before you leave.</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endif

            <x-list-extras :booking="$booking" :extras="$extras"></x-list-extras>
        </div>
    </div>


</x-layouts.app>
