<x-layouts.app>
    <div class="relative -mt-28 overflow-hidden bg-[#fff7ef] pt-28 text-gray-950 sm:-mt-32 sm:pt-32">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(127,231,255,0.25),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(255,214,10,0.20),_transparent_30%),linear-gradient(180deg,_rgba(255,247,239,1)_0%,_rgba(255,247,239,0.96)_55%,_rgba(255,247,239,1)_100%)]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute left-[-3rem] top-24 h-28 w-28 rounded-full border-4 border-black/80 bg-[#7fe7ff] blur-[2px]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute right-[-2rem] top-44 h-20 w-20 rounded-[1.5rem] border-4 border-black/80 bg-[#ffd54a] rotate-12"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border-2 border-black/80 bg-black/5 px-4 py-2 text-xs font-black uppercase tracking-[0.28em]">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#7fe7ff]"></span>
                    Almost There
                </div>
                <h1 class="font-heading text-[clamp(2.6rem,7vw,5.5rem)] font-black uppercase leading-[0.9] tracking-[-0.04em] text-black">
                    @setting('book_checkout_title', 'Confirm Your Selection')
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-black/65 sm:text-lg">
                    @setting('book_checkout_description', 'If these dates are OK we will check availability and book for you, you may be able to choose different days for some events.')
                </p>
            </div>

            <div class="mx-auto max-w-3xl">
                <form action="{{ route('book.checkout') }}" method="POST">
                    @csrf

                    <div class="overflow-hidden rounded-[2.25rem] border-4 border-black bg-white shadow-[10px_10px_0_0_#171717]">
                        <div class="border-b-4 border-black bg-[#7fe7ff] px-6 py-5 sm:px-8">
                            <p class="text-xs font-black uppercase tracking-[0.28em] text-black/60">Step 2 of 2</p>
                            <p class="mt-1 font-heading text-2xl font-black uppercase leading-none tracking-[-0.02em] sm:text-3xl">Your Events</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 sm:p-8">
                            @foreach ($dates as $date)
                                <div class="overflow-hidden rounded-[1.5rem] border-2 border-black bg-[#fff7ef] shadow-[4px_4px_0_0_#171717]">
                                    <div class="flex items-center gap-4 p-4">
                                        <img src="{{ \App\Models\Event::where('name', data_get($date->first(), 'name'))->first()?->getFirstMedia('images')?->getUrl() }}"
                                            class="h-20 w-20 shrink-0 rounded-xl border-2 border-black object-cover shadow-[2px_2px_0_0_#171717]"
                                            alt="{{ data_get($date->first(), 'name') }}">
                                        <div class="min-w-0">
                                            <p class="text-xs font-black uppercase tracking-[0.18em] text-black/50">Event</p>
                                            <h3 class="mt-0.5 truncate text-sm font-black uppercase leading-5 text-black">
                                                {{ data_get($date->first(), 'name') }}
                                            </h3>
                                            <p class="mt-1 truncate text-xs font-medium text-black/60">
                                                @if (count($date) > 1)
                                                    Multiple dates &mdash; select below
                                                @else
                                                    {{ data_get($date->first(), 'date')?->format('l jS F Y') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (count($select_options) > 0)
                            <div class="border-t-4 border-black bg-[#fff0be] px-6 py-6 sm:px-8">
                                <p class="text-xs font-black uppercase tracking-[0.28em] text-black/50">Date Selection Required</p>
                                <p class="mt-1 text-sm font-medium text-black/65">The following events have multiple dates - pick your preferred.</p>
                                <div class="mt-6 space-y-5">
                                    @foreach ($select_options as $event => $options)
                                        <div>
                                            <label for="{{ Str::of($event)->slug() }}" class="block text-xs font-black uppercase tracking-[0.18em] text-black">{{ $event }}</label>
                                            <select id="{{ Str::of($event)->slug() }}" name="{{ Str::of($event)->slug() }}"
                                                class="mt-2 block w-full rounded-xl border-2 border-black bg-white px-4 py-3 text-sm font-medium text-black shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                                                @foreach ($options as $option)
                                                    <option value="{{ data_get($option, 'date') }}">{{ data_get($option, 'date')?->format('l jS F Y') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between gap-4 border-t-4 border-black bg-white px-6 py-5 sm:px-8">
                            <a href="/book" class="text-xs font-black uppercase tracking-[0.18em] text-black/50 transition-colors duration-150 hover:text-black">
                                &larr; Back
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-8 py-3 text-sm font-black uppercase tracking-[0.18em] text-black shadow-[4px_4px_0_0_#171717] transition-transform duration-200 hover:-translate-y-1">
                                Confirm Booking &rarr;
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('booking_site') !== 'zec')
        <x-newsletter></x-newsletter>
    @endif
</x-layouts.app>
