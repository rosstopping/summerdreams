<x-layouts.app>
    <div class="relative -mt-28 overflow-hidden pt-28 text-gray-950 sm:-mt-32 sm:pt-32">
        <div class="relative mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8">

            <div class="mb-12 text-center">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border-2 border-black/80 bg-black/5 px-4 py-2 text-xs font-black uppercase tracking-[0.28em]">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#ffd54a]"></span>
                    Reserve Your Place
                </div>
                <h1 class="font-heading text-[clamp(2.6rem,7vw,5.5rem)] font-black uppercase leading-[0.9] tracking-[-0.04em] text-black">
                    @setting('book_event_title', 'Book Your Tickets')
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-black/65 sm:text-lg">
                    @setting('book_event_description', 'Complete the form below to reserve your tickets. Events with selected dates will be based upon your arrival date, you can confirm these dates in the next step.')
                </p>
            </div>

            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden rounded-[2.25rem] border-4 border-black bg-white shadow-[10px_10px_0_0_#171717]">
                    <div class="border-b-4 border-black bg-[#ff6fa9] px-6 py-5 sm:px-8">
                        <p class="text-xs font-black uppercase tracking-[0.28em] text-black/60">Step 1 of 2</p>
                        <p class="mt-1 font-heading text-2xl font-black uppercase leading-none tracking-[-0.02em] text-white sm:text-3xl">Your Details</p>
                    </div>
                    <div class="px-6 py-8 sm:px-8">
                        <x-alerts></x-alerts>
                        <form action="{{ route('book.submit', $event) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="event">
                            @include('book.partials.form')
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
