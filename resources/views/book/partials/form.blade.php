<input type="hidden" name="reference" value="{{ request()->get('reference') }}" />
<input type="hidden" name="upgrade" value="{{ request()->get('upgrade') }}" />
<input type="hidden" name="discount" value="{{ session('discount') ?: request()->get('discount') }}">

<div class="space-y-8">
    <div>
        <h2 class="text-xs font-black uppercase tracking-[0.28em] text-black/50">Your Information</h2>
        <p class="mt-1 text-sm font-medium leading-6 text-black/60">Tell us who you are and where we should send your booking confirmation.</p>
        <div class="mt-6 grid grid-cols-1 gap-x-5 gap-y-6 sm:grid-cols-6">

            <div class="sm:col-span-3">
                <label for="guests" class="block text-xs font-black uppercase tracking-[0.18em] text-black">Group Size</label>
                <div class="mt-2">
                    <input value="{{ old('guests') ?: 1 }}" type="number" name="guests" id="guests" step="1" min="1"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff7ef] px-4 py-3 text-sm font-medium text-black placeholder-black/30 shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="name" class="block text-xs font-black uppercase tracking-[0.18em] text-black">Full Name</label>
                <div class="mt-2">
                    <input value="{{ old('name') }}" type="text" name="name" id="name" autocomplete="given-name"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff7ef] px-4 py-3 text-sm font-medium text-black placeholder-black/30 shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="email" class="block text-xs font-black uppercase tracking-[0.18em] text-black">Email Address</label>
                <div class="mt-2">
                    <input value="{{ old('email') }}" id="email" name="email" type="email" autocomplete="email"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff7ef] px-4 py-3 text-sm font-medium text-black placeholder-black/30 shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="mobile" class="block text-xs font-black uppercase tracking-[0.18em] text-black">Mobile</label>
                <div class="mt-2">
                    <input value="{{ old('mobile') }}" type="text" name="mobile" id="mobile" autocomplete="tel"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff7ef] px-4 py-3 text-sm font-medium text-black placeholder-black/30 shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="arrival_date" class="block text-xs font-black uppercase tracking-[0.18em] text-black">Arrival Date</label>
                <div class="mt-2">
                    <x-date-picker value="{{ old('arrival_date') ?: $start_date }}" min="{{ $start_date }}" name="arrival_date"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff7ef] px-4 py-3 text-sm font-medium text-black placeholder-black/30 shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0"></x-date-picker>
                </div>
            </div>

        </div>

        @if (session('discount') || request()->get('discount'))
            <div class="mt-8">
                <h2 class="text-xs font-black uppercase tracking-[0.28em] text-black/50">Discount Code</h2>
                <div class="mt-3 max-w-xs">
                    <input value="{{ session('discount') ?: request()->get('discount') }}" type="text" name="discount" id="discount"
                        class="block w-full rounded-xl border-2 border-black bg-[#fff0be] px-4 py-3 text-sm font-black text-black shadow-[3px_3px_0_0_#171717] focus:border-black focus:ring-0">
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-8 flex items-center justify-between gap-4 border-t-2 border-black/10 pt-6">
    <a href="/book" class="text-xs font-black uppercase tracking-[0.18em] text-black/50 hover:text-black transition-colors duration-150">
        &larr; Cancel
    </a>
    <button type="submit"
        class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-8 py-3 text-sm font-black uppercase tracking-[0.18em] text-black shadow-[4px_4px_0_0_#171717] transition-transform duration-200 hover:-translate-y-1">
        Continue &rarr;
    </button>
</div>
