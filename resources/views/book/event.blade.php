<x-layouts.app>
    <div class="relative -mt-28 overflow-hidden bg-[#fff7ef] pt-28 text-gray-950 sm:-mt-32 sm:pt-32">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(255,111,176,0.25),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(255,214,10,0.20),_transparent_30%),linear-gradient(180deg,_rgba(255,247,239,1)_0%,_rgba(255,247,239,0.96)_55%,_rgba(255,247,239,1)_100%)]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute left-[-3rem] top-24 h-28 w-28 rounded-full border-4 border-black/80 bg-[#ff6fa9] blur-[2px]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute right-[-2rem] top-40 h-20 w-20 rounded-[1.5rem] border-4 border-black/80 bg-[#ffd54a] rotate-12"></div>

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
