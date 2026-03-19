<input type="hidden" name="reference" value="{{ request()->get('reference') }}" />
<input type="hidden" name="upgrade" value="{{ request()->get('upgrade') }}" />
<input type="hidden" name="discount" value="{{ session('discount') ?: request()->get('discount') }}">
<div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Your Information</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Tell us who you are and where we should send your booking confirmation.</p>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Group Size</label>
                <div class="mt-2">
                    <input value="{{ old('guests') ?: 1 }}" type="number" name="guests" id="guests" step="1" min="1" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                    <input value="{{ old('name') }}" type="text" name="name" id="name" autocomplete="given-name" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input value="{{ old('email') }}" id="email" name="email" type="email" autocomplete="email" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Mobile</label>
                <div class="mt-2">
                    <input value="{{ old('mobile') }}" type="text" name="mobile" id="mobile" autocomplete="tel" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Arrival Date</label>
                <div class="mt-2">
                    <x-date-picker value="{{ old('arrival_date') ?: $start_date }}" min="{{ $start_date }}" name="arrival_date" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6"></x-date-picker>
                </div>
            </div>
        </div>
        @if (session('discount') || request()->get('discount'))
            <h2 class="text-base font-semibold leading-7 text-gray-900 mt-12">Discount Code</h2>
            {{-- <p class="mt-1 text-sm leading-6 text-gray-600">If you have a disount code please enter it here.</p> --}}
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <div class="mt-2">
                        <input value="{{ session('discount') ?: request()->get('discount') }}" type="text" name="discount" id="discount" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="mt-6 flex items-center justify-end gap-x-6">
    <a href="/make-reservation" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
    <button type="submit" class=" bg-brand px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Continue</button>
</div>