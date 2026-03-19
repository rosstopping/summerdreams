@php
    $gridClasses = match($packages->count()) {
        2 => 'md:grid-cols-2',
        3 => 'md:grid-cols-3',
        4 => 'md:grid-cols-2',
        default => 'md:grid-cols-3'
    };
    $centerClass = $packages->count() === 2 ? 'lg:justify-center' : '';
@endphp
<div id="book" class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <div class="isolate mt-10 grid grid-cols-1 gap-8 {{ $gridClasses }} {{ $centerClass }}">
        @foreach ($packages as $package)
        <div class="group relative overflow-hidden rounded-[2.25rem] border-4 border-black p-8 sm:p-10 shadow-[10px_10px_0_0_#171717] sm:shadow-[12px_12px_0_0_#171717] lg:shadow-[14px_14px_0_0_#171717] {{ $package->featured ? 'order-first md:order-none -m-1 border-[5px] bg-[#ff6fa9]' : 'bg-[#fff0be]' }}">
            <!-- Decorative accent -->
            <div aria-hidden="true" class="pointer-events-none absolute -left-6 -top-6 h-20 w-20 rounded-full border-4 border-black {{ $package->featured ? 'bg-[#ffd54a]' : 'bg-[#7fe7ff]' }}"></div>

            <div class="relative z-10">
                <div class="flex items-start justify-between gap-x-4">
                    <h3 class="font-heading text-[clamp(1.5rem,4vw,2rem)] font-black uppercase leading-tight tracking-tight {{ $package->featured ? 'text-white' : 'text-black' }}">{{ $package->name }}</h3>
                    @if ($package->popular)
                    <p class="rounded-full border-2 {{ $package->featured ? 'border-white bg-white/20' : 'border-black bg-[#ffd54a]' }} px-3 py-1 text-xs font-black uppercase tracking-widest {{ $package->featured ? 'text-white' : 'text-black' }}">Popular</p>
                    @endif
                </div>
                
                <p class="mt-4 text-sm leading-relaxed {{ $package->featured ? 'text-white/90' : 'text-black/70' }}">{{ $package->description }}</p>
                
                <div class="mt-8 flex items-baseline gap-x-2">
                    <span class="font-heading text-[clamp(2.5rem,6vw,3.5rem)] font-black {{ $package->featured ? 'text-white' : 'text-black' }}">@currency($package->currency->value){{ $package->amount }}</span>
                    @if ($package->deposit)
                        <span class="text-xs font-black uppercase tracking-widest {{ $package->featured ? 'text-white/75' : 'text-black/60' }}">@currency($package->currency->value){{ $package->deposit }} deposit</span>
                    @endif
                </div>

                <a href="{{ route('book.package', $package) }}" class="mt-8 block rounded-full border-3 {{ $package->featured ? 'border-white bg-white text-[#ff6fa9]' : 'border-black bg-black text-white' }} px-8 py-3 text-center text-xs font-black uppercase tracking-widest transition-all duration-200 hover:shadow-[8px_8px_0_0_rgba(0,0,0,0.2)] active:shadow-[3px_3px_0_0_rgba(0,0,0,0.2)]">Book Package</a>
                
                @if ($package->includes)
                <ul role="list" class="mt-8 space-y-3 border-t-2 {{ $package->featured ? 'border-white/30' : 'border-black/10' }} pt-8">
                    @foreach ($package->includes as $include)
                    <li class="flex gap-x-3 text-sm leading-relaxed {{ $package->featured ? 'text-white/90' : 'text-black/70' }}">
                        <svg class="h-5 w-5 flex-none font-black {{ $package->featured ? 'text-white' : 'text-[#ffd54a]' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ data_get($include, 'fields.description') }}
                    </li>
                    @endforeach
                </ul>
                @endif

                @if ($package->upgrade)
                <div class="mt-8 border-t-2 {{ $package->featured ? 'border-white/30' : 'border-black/10' }} pt-8">
                    <h4 class="font-heading text-[clamp(1.3rem,3vw,1.6rem)] font-black uppercase tracking-tight {{ $package->featured ? 'text-white' : 'text-black' }}">{{ $package->upgrade->title }}</h4>
                    
                    <div class="mt-4 flex items-baseline gap-x-2">
                        <span class="font-heading text-2xl font-black {{ $package->featured ? 'text-white' : 'text-black' }}">@currency($package->currency->value){{ $package->amount + $package->upgrade->amount }}</span>
                        @if ($package->upgrade->deposit)
                            <span class="text-xs font-black uppercase tracking-widest {{ $package->featured ? 'text-white/75' : 'text-black/60' }}">@currency($package->currency->value){{ $package->upgrade->deposit }} deposit</span>
                        @endif
                    </div>

                    <a href="{{ route('book.package', [$package, 'upgrade' => $package->upgrade->id]) }}" class="mt-4 block rounded-full border-3 {{ $package->featured ? 'border-white/50 bg-white/10 text-white' : 'border-black bg-[#7fe7ff] text-black' }} px-8 py-2 text-center text-xs font-black uppercase tracking-widest transition-all duration-200 hover:shadow-[6px_6px_0_0_rgba(0,0,0,0.2)] active:shadow-[2px_2px_0_0_rgba(0,0,0,0.2)]">Get Upgrade</a>
                    
                    @if ($package->upgrade->includes)
                    <ul role="list" class="mt-4 space-y-2 text-xs leading-relaxed {{ $package->featured ? 'text-white/90' : 'text-black/70' }}">
                        @foreach ($package->upgrade->includes as $include)
                        <li class="flex gap-x-2">
                            <span class="text-[#ffd54a]">+</span>
                            {{ data_get($include, 'fields.description') }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
