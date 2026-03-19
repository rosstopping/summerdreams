<div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
            {{-- <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Book Event</p> --}}
        </div>
        {{-- <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">Enter your seller code below to access the booking page.</p> --}}
        <form wire:submit="createBooking" class="max-w-xs mx-auto mt-16">
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
                <div>
                    <label for="event" class="block text-sm font-medium leading-6 text-gray-900">Event</label>
                    <div class="mt-2">
                        <select wire:model.live="event" id="event" name="event" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option>Select Event</option>
                            @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                                    
                        @error('event') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                    </div>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date</label>
                    <div class="mt-2">
                        <select wire:model.live="date" id="date" name="date" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option>Select Date</option>
                            @foreach ($dates as $date)
                            <option value="{{ $date->format('Y-m-d') }}">{{ $date->format('jS F Y  (l)') }}</option>
                            @endforeach
                        </select>
                                    
                        @error('date') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                    </div>
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium leading-6 text-gray-900">Payment Method</label>
                    <div class="mt-2">
                        <select wire:model.live="payment_method" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                                    
                        @error('payment_method') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                    </div>
                </div>
                @if ($payment_method === 'cash')
                    <div>
                        <label for="currency" class="block text-sm font-medium leading-6 text-gray-900">Currency</label>
                        <div class="mt-2">
                            <select wire:model="currency" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="gbp">£GBP</option>
                                <option value="eur">€Euros</option>
                            </select>
                                        
                            @error('payment_method') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                @endif
                {{-- <div>
                    <label for="customer_name" class="block text-sm font-medium leading-6 text-gray-900">Customer Name</label>
                    <div class="mt-2">
                        <input wire:model="customer_name" type="text" class="mt-2 block w-full  border-0 py-1.5 pl-3 pr-10 text-gray-900 border-2 border-black focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    
                        @error('customer_name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                    </div>
                </div>
                <div>
                    <label class="text-xs flex items-center gap-1">
                        <input wire:model="additional_details" type="checkbox" name="additional_details"> Require additional details
                                    
                        @error('additional_details') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror 
                    </label>
                </div> --}}
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class=" bg-brand px-6 py-3 text-sm font-bold text-white border-2 border-black hover:bg-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all uppercase">Create Booking</button>
            </div>
            <div class="py-12">
                @if ($qrcode)
                    <div class="text-center text-xs uppercase pb-3 opacity-75">Scan the below QR Code</div>
                    <a href="{{ $url }}" class="block bg-white  shadow-sm mx-auto p-4 *:w-full *:h-auto">
                        {!! $qrcode !!}
                    </a>
                    <div class="text-center mt-4">
                        <a href="{{ $url }}">Continue to book ></a>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>