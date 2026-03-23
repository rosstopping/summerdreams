<x-layouts.blank>
    <img src="/images/logo-dark.png" alt="{{ config('app.name') }}" class="h-20 my-6 w-auto mx-auto" />
    <div class="space-y-12 p-6">
        <div class="border-b border-gray-900/10 pb-12">
            <form action="{{ route('seller.book.submit', [$seller, $event, $date, $payment_method, $currency]) }}" method="POST" class="max-w-3xl mx-auto">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Your Information</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Tell us who you are and where we should send your booking confirmation.</p>
                <x-alerts></x-alerts>
                @csrf
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
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class=" bg-brand px-6 py-3 text-sm font-bold text-white border-2 border-black hover:bg-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all uppercase">Continue</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.blank>
