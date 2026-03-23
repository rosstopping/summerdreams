<div class="isolate px-6 lg:px-8">
    <form action="{{ route('contact') }}" method="POST" class="mx-auto {{ data_get($content, 'large') ? 'max-w-2xl' : 'max-w-xl' }}"  enctype="multipart/form-data">
        <x-alerts></x-alerts>
        @honeypot
        @csrf
        <input type="hidden" name="key" value="{{ $content->key() }}" />
        <div class="grid grid-cols-1 {{ data_get($content, 'large') ? 'gap-x-6 gap-y-6' : 'gap-x-8 gap-y-2' }} sm:grid-cols-2">
            @foreach ($content->fields ?? [] as $field)
            @php
                $fieldType = $field->attributes->type ?? null;
                $fieldName = $field->attributes->name ?? null;
                $fieldOptions = $field->attributes->options ?? '';
                $fieldRequired = $field->attributes->required ?? false;
                $fieldFullWidth = $field->attributes->full_width ?? false;
            @endphp
            @if($fieldType && $fieldName)
            <div class="@if ($fieldType === 'textarea') sm:col-span-2 @endif @if ($fieldFullWidth === true) col-span-full @endif">
                @if ($fieldType === 'select')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <select 
                        name="{{ Str::of($fieldName)->snake() }}" 
                        id="{{ $fieldName }}" 
                        class="block w-full {{ data_get($content, 'large') ? ' px-4 py-3.5 text-base' : ' px-3.5 py-2 sm:text-sm sm:leading-6' }} border-0 text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] rounded-xl border-3 border-black placeholder:text-gray-400 focus:ring-2 focus:ring-brand focus:border-brand transition-all">
                        <option value="">Select an option</option>
                        @foreach (explode(',', $fieldOptions) as $option)
                            <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                        @endforeach
                    </select>
                @endif
                @if ($fieldType === 'text' || $fieldType === 'email' || $fieldType === 'number')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <input
                        @if ($fieldType === 'number') min="1" step="1" @endif
                        type="{{ $fieldType === 'mobile' ? 'tel' : $fieldType }}"
                        value="{{ old($fieldName) }}"
                        name="{{ Str::of($fieldName)->snake() }}"
                        id="{{ $fieldName }}"
                        @if ($fieldType === 'mobile') autocomplete="tel" @endif
                        @if ($fieldType === 'email') autocomplete="email" @endif
                        class="block w-full {{ data_get($content, 'large') ? ' px-4 py-3.5 text-base' : ' px-3.5 py-2 sm:text-sm sm:leading-6' }} border-0 text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] rounded-xl border-3 border-black placeholder:text-gray-400 focus:border-pink-400 focus:ring-2 focus:ring-pink-400 transition-all">
                @endif

                @if ($fieldType === 'mobile')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <x-phone-number
                        name="{{ Str::of($fieldName)->snake() }}"
                        class="block w-full {{ data_get($content, 'large') ? ' px-4 py-3.5 text-base' : ' px-3.5 py-2 sm:text-sm sm:leading-6' }} border-0 text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] rounded-xl border-3 border-black placeholder:text-gray-400 focus:border-pink-400 focus:ring-2 focus:ring-pink-400 transition-all"></x-phone-number>
                @endif

                @if ($fieldType === 'date')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <x-date-picker
                        name="{{ Str::of($fieldName)->snake() }}"
                        value="{{ old($fieldName) }}"
                        min="{{ $fieldName === 'Arrival Date' ? today()->format('m') > 9 ? today()->month(5)->day(1)->addYear() : today()->month(5)->day(1) : today() }}"
                        class="block w-full {{ data_get($content, 'large') ? ' px-4 py-3.5 text-base' : ' px-3.5 py-2 sm:text-sm sm:leading-6' }} border-0 text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] rounded-xl border-3 border-black placeholder:text-gray-400 focus:border-pink-400 focus:ring-2 focus:ring-pink-400 transition-all"></x-date-picker>
                @endif

                @if ($fieldType === 'textarea')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <textarea 
                        name="{{ Str::of($fieldName)->snake() }}" 
                        id="{{ $fieldName }}" 
                        rows="{{ data_get($content, 'large') ? '5' : '4' }}" 
                        class="block w-full {{ data_get($content, 'large') ? ' px-4 py-3.5 text-base resize-y' : ' px-3.5 py-2 sm:text-sm sm:leading-6' }} border-0 text-gray-900 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] rounded-xl border-3 border-black placeholder:text-gray-400 focus:border-pink-400 focus:ring-2 focus:ring-pink-400 transition-all">{{ old($fieldName) }}</textarea>
                @endif

                @if ($fieldType === 'file')
                    <label for="{{ $fieldName }}" class="block {{ data_get($content, 'large') ? 'text-base font-black mb-3' : 'text-sm font-bold mb-2' }} uppercase leading-6 text-gray-900">
                        {{ $fieldName }}
                    </label>
                    <input 
                        name="{{ Str::of($fieldName)->snake() }}" 
                        id="{{ $fieldName }}" 
                        type="file"  
                        class="block w-full {{ data_get($content, 'large') ? 'text-base file:py-2.5 file:px-4 file:' : 'text-sm file:py-2 file:px-3 file:' }} text-gray-900 file:mr-4 file:border-0 file:font-bold file:bg-pink-400 file:text-white hover:file:bg-pink-500 file:cursor-pointer file:rounded-lg file:transition-colors cursor-pointer rounded-xl border-3 border-black" />
                @endif

                @if ($fieldType === 'boolean')
                    <label class="{{ data_get($content, 'large') ? 'text-base gap-3' : 'text-sm gap-2' }} font-bold text-gray-900 flex items-center cursor-pointer">
                        <input 
                            name="{{ Str::of($fieldName)->snake() }}" 
                            id="{{ $fieldName }}" 
                            type="checkbox" 
                            class="{{ data_get($content, 'large') ? 'w-5 h-5' : 'w-4 h-4' }} rounded border-2 border-black text-pink-600 focus:ring-2 focus:ring-pink-400 cursor-pointer" /> 
                        <span>{{ $fieldName }}</span>
                    </label>
                @endif
            </div>
            @endif
            @endforeach
            {{-- <div>
                <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
                <div class="mt-2.5">
                    <input value="{{ old('email') }}" type="email" name="email" id="email" autocomplete="email" class="block w-full  border-0 px-3.5 py-2 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            @if (data_get($content, 'group_size'))
            <div>
                <label for="group_size" class="block text-sm font-semibold leading-6 text-gray-900">Group Size</label>
                <div class="mt-2.5">
                    <input type="number" step="1" min="1" value="{{ old('group_size') ?: 1 }}" name="group_size" id="group_size" class="block w-full  border-0 px-3.5 py-2 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                </div>
            </div>
            @endif
            @if (data_get($content, 'arrival_date'))
                <div>
                    <label for="arrival_date" class="block text-sm font-semibold leading-6 text-gray-900">Arrival Date</label>
                    <div class="mt-2.5">
                        <x-date-picker name="arrival_date"  value="{{ old('arrival_date') }}" min="" class="block w-full  border-0 px-3.5 py-2 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6"></x-date-picker>
                    </div>
                </div>
            @endif
            <div class="sm:col-span-2">
                <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Message</label>
                <div class="mt-2.5">
                    <textarea name="message" id="message" rows="4" class="block w-full  border-0 px-3.5 py-2 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">{{ old('message') }}</textarea>
                </div>
            </div> --}}
        </div>
        <div class="{{ data_get($content, 'large') ? 'mt-8' : 'mt-6' }}">
            <button type="submit" class="block w-full {{ data_get($content, 'large') ? ' px-6 py-4 text-base' : ' px-3.5 py-2.5 text-sm' }} bg-brand text-center font-black text-black shadow-[6px_6px_0px_rgba(0,0,0,0.15)] hover:shadow-[8px_8px_0px_rgba(0,0,0,0.2)] rounded-2xl border-3 border-black hover:from-pink-600 hover:to-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all cursor-pointer uppercase tracking-tight">
                {{ data_get($content, 'button_text', 'Send message') }}
            </button>
        </div>
    </form>
</div>