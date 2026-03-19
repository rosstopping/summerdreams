@if ($extras->count() > 0)
    <h2 class="text-lg font-semibold text-gray-900 mt-6">Booking Extras</h2>
    <div class="mx-auto max-w-7xl">
      <div class="w-full isolate mx-auto mt-10 grid gap-y-10 grid-cols-1 lg:mx-0 lg:grid-cols-3">
        @foreach ($extras as $extra)
            <div class="max-w-lg  p-8 xl:p-10 ring-1 {{ $loop->iteration === 2 ? '-mx-1 lg:scale-110 z-10 bg-brand text-white ring-transparent shadow-2xl order-first md:order-none' : 'ring-gray-200 bg-white' }}">

                <div class="-mx-8 xl:-mx-10 -mt-8 xl:-mt-10 mb-8 rounded-t-3xl overflow-hidden h-52 relative flex items-end px-10 pb-8">
                    @if ($extra->image)
                        <img src="{{ Storage::url($extra->image) }}" class="w-full h-full object-cover absolute inset-0" />
                    @endif
                    <div class="absolute inset-0 w-full h-full bg-linear-to-b from-transparent to-black opacity-75"></div>
                    <h3 class="relative text-xl font-semibold leading-8 @if ($extra->image) text-white @endif">{{ $extra->name }}</h3>
                </div>

                <div class="prose prose-sm {{ $loop->iteration === 2 ? 'text-white prose-white' : '' }}">
                    {!! $extra->description !!}
                </div>

                <div x-data='{
                    quantity: {{ $booking->guests }},
                    deposits: @json($extra->depositPrices),
                    amounts: @json($extra->amountPrices),
                }' class="mt-6">
                    <h3 class="font-semibold mb-2">Reserve Now</h3>
                    <form method="POST" action="{{ route('add-extra', $extra) }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                        @if ($extra->amount_type != 'fixed')
                        <label class="block mb-2">
                            <p class="text-xs mb-1">Number of guests</p>
                            <input name="quantity" type="number" x-model="quantity" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6" />
                        </label>
                        @endif
                        @if ($extra->date_required)
                        <label class="block mb-2">
                            <p class="text-xs mb-1">Date</p>
                            <x-date-picker value="{{ $booking->arrival_date }}" name="date" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6"></x-date-picker>
                        </label>
                        @endif
                        </div>
                        <template x-if="deposits[quantity]">
                            <button class="inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-5 py-2 text-sm">Add to booking (&pound;<span x-text="deposits[quantity]"></span>)</button>
                        </template>
                    </form>
                    <p x-bind:class="amounts[quantity] > deposits[quantity] ? 'visible' : 'invisible'" class="text-xs mt-6 opacity-75">*Balance payment of &pound;<span x-html="amounts[quantity] - deposits[quantity]"></span> will be due on ticket collection.</p>
                </div>
        </div>
        @endforeach
      </div>
    </div>
@endif
