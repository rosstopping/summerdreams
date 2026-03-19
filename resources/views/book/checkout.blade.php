<x-layouts.app>
    <div class=" py-24 sm:py-32 mt-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">@setting('book_checkout_title', 'Confirm your selection')</p>
            </div>
            <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">@setting('book_checkout_description', 'If these dates are OK we will check availability and book for you, you may be able to choose different days for some events.')</p>
            <form action="{{ route('book.checkout') }}" method="POST" class="max-w-3xl mx-auto mt-16">
                @csrf
                <div class="space-y-12">
                    <div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($dates as $date)
                                <div class="bg-white  shadow-xl p-4">
                                    <div class="flex items-center gap-x-4">
                                        <img src="{{ \App\Models\Event::where('name', data_get($date->first(), 'name'))->first()?->getFirstMedia('images')?->getUrl() }}" class="w-24 h-24 object-cover ">
                                        <div class="flex-auto">
                                            <h3 class=" truncate text-sm font-semibold leading-6 text-gray-900">
                                                {{ data_get($date->first(), 'name') }}
                                            </h3>
                                            <p class="mt-3 truncate text-sm text-gray-500">
                                                @if (count($date) > 1)
                                                    Multiple dates, select below
                                                @else
                                                    {{ data_get($date->first(), 'date')?->format('l jS F Y') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>

                    @if (count($select_options) > 0)
                        <div class="border-b border-gray-900/10 pb-12 mt-20 max-w-xl mx-auto">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Select event dates</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">The following events require you to input a preferred date.</p>
                            <div class="mt-6">
                                @foreach ($select_options as $event => $options)
                                <div>
                                    <label for="{{ Str::of($event)->slug() }}" class="block text-sm font-medium leading-6 text-gray-900">{{ $event }}</label>
                                    <select id="{{ Str::of($event)->slug() }}" name="{{ Str::of($event)->slug() }}" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        @foreach ($options as $option)
                                        <option value="{{ data_get($option, 'date') }}">{{ data_get($option, 'date')?->format('l jS F Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-6 pb-12 flex items-center justify-end gap-x-6">
                    <a href="/make-reservation" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <button type="submit" class=" bg-brand px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{-- {{ $booking->packages()->first() && !$booking->packages()->first()->bookable ? 'Confirm booking' : 'Go to payment' }} --}}
                        Confirm booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (session('booking_site') !== 'zec')
        <x-newsletter></x-newsletter>
    @endif
</x-layouts.app>
