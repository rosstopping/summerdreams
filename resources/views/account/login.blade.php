<x-layouts.app>
    <div class="relative overflow-x-hidden bg-[#fff7ef] text-gray-950">
        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 -z-0 h-[36rem] bg-[radial-gradient(circle_at_top_left,_rgba(255,111,176,0.3),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(255,214,10,0.2),_transparent_30%),linear-gradient(180deg,_rgba(255,247,239,1)_0%,_rgba(255,247,239,0.96)_55%,_rgba(255,247,239,1)_100%)]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -left-12 top-24 h-32 w-32 rounded-full border-4 border-black bg-[#ffd54a]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -right-10 top-32 h-24 w-24 rotate-12 rounded-[1.35rem] border-4 border-black bg-[#7fe7ff]"></div>

        <section class="relative px-4 pb-10 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl overflow-hidden rounded-[2.25rem] border-4 border-black bg-white shadow-[10px_10px_0_0_#171717] sm:shadow-[14px_14px_0_0_#171717]">
                <div class="grid gap-0 lg:grid-cols-[1.05fr_0.95fr]">
                    <div class="bg-[#111111] px-6 py-10 text-white sm:px-10 lg:px-12 lg:py-14">
                        <p class="text-xs font-black uppercase tracking-[0.26em] text-[#7fe7ff]">Manage My Booking</p>
                        <h1 class="mt-4 font-heading text-[clamp(2.3rem,5.6vw,4.9rem)] font-black uppercase leading-[0.9] tracking-[-0.03em]">Access Your Booking</h1>
                        <p class="mt-5 max-w-2xl text-sm leading-7 text-white/80 sm:text-base">Complete the form below to view your booking summary, update details, and manage extras.</p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-[1.1rem] border-2 border-white/80 bg-white/10 px-4 py-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">Summary</p>
                                <p class="mt-2 text-sm font-bold uppercase">View Booking</p>
                            </div>
                            <div class="rounded-[1.1rem] border-2 border-white/80 bg-white/10 px-4 py-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">Details</p>
                                <p class="mt-2 text-sm font-bold uppercase">Update Info</p>
                            </div>
                            <div class="rounded-[1.1rem] border-2 border-white/80 bg-white/10 px-4 py-4">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">Extras</p>
                                <p class="mt-2 text-sm font-bold uppercase">Add Upgrades</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative bg-[#ff6fa9] p-6 sm:p-8 lg:p-10">
                        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full border-4 border-black bg-[#ffd54a]"></div>
                        <div class="relative overflow-hidden rounded-[1.5rem] border-4 border-black bg-white shadow-[8px_8px_0_0_#171717]">
                            <img src="{{ Vite::asset('resources/images/events/vice-parties/IMG_5778.jpg') }}" alt="Summer Dreams booking login" class="h-[18rem] w-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative z-10 px-4 pb-20 pt-4 sm:px-6 sm:pt-6 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:items-start">
                <div class="rounded-[2rem] border-4 border-black bg-[#fff0be] p-6 shadow-[10px_10px_0_0_#171717] sm:p-8">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-black/60">Secure Login</p>

                    <form method="POST" class="mt-6">
                        <x-alerts></x-alerts>
                        @csrf

                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="arrival_date" class="block text-xs font-black uppercase tracking-[0.16em] text-black/70">Arrival Date</label>
                                <div class="mt-2">
                                    <x-date-picker value="{{ old('arrival_date') }}" min="{{ today()->format('m') > 9 ? today()->month(5)->day(1)->addYear() : today()->month(5)->day(1) }}" name="arrival_date" class="block w-full rounded-[0.9rem] border-2 border-black bg-white px-4 py-2.5 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-0"></x-date-picker>
                                </div>
                            </div>

                            <div>
                                <label for="reference" class="block text-xs font-black uppercase tracking-[0.16em] text-black/70">Booking Reference</label>
                                <div class="mt-2">
                                    <input value="{{ old('reference') }}" type="text" name="reference" id="reference" class="block w-full rounded-[0.9rem] border-2 border-black bg-white px-4 py-2.5 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-0">
                                </div>
                            </div>

                            <div>
                                <label for="name" class="block text-xs font-black uppercase tracking-[0.16em] text-black/70">Booking Name</label>
                                <div class="mt-2">
                                    <input value="{{ old('name') }}" type="text" name="name" id="name" autocomplete="given-name" class="block w-full rounded-[0.9rem] border-2 border-black bg-white px-4 py-2.5 text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:border-black focus:ring-0">
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-6 py-3 text-sm font-black uppercase tracking-[0.18em] text-black transition-transform duration-200 hover:-translate-y-1 sm:w-auto">Login To Your Booking</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="rounded-[2rem] border-4 border-black bg-white p-6 shadow-[10px_10px_0_0_#171717] sm:p-8">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-black/60">What You Can Do</p>
                    <h2 class="mt-3 font-heading text-[clamp(2rem,4vw,3.2rem)] font-black uppercase leading-[0.92] tracking-[-0.03em]">Inside Manage My Booking</h2>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-[1.2rem] border-2 border-black bg-[#7fe7ff] px-5 py-4">
                            <p class="text-sm font-black uppercase leading-6">View your booking summary and complete payment if necessary</p>
                        </div>
                        <div class="rounded-[1.2rem] border-2 border-black bg-[#ffd54a] px-5 py-4">
                            <p class="text-sm font-black uppercase leading-6">Update passenger details and keep your contact information up to date</p>
                        </div>
                        <div class="rounded-[1.2rem] border-2 border-black bg-[#ff6fa9] px-5 py-4 text-white">
                            <p class="text-sm font-black uppercase leading-6">Book extra excursions to make your holiday extra special</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
</x-layouts.app>
