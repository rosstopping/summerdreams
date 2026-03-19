<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-24">
    <div class="mx-auto grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @foreach ($events as $event)
            <div class="group relative overflow-hidden rounded-[2.25rem] border-4 border-black bg-white shadow-[8px_8px_0_0_#171717] sm:shadow-[10px_10px_0_0_#171717] lg:shadow-[12px_12px_0_0_#171717]">
                <!-- Decorative accent -->
                <div aria-hidden="true" class="pointer-events-none absolute -right-4 top-6 h-16 w-16 rotate-12 rounded-[0.875rem] border-3 border-black bg-[#ffd54a]"></div>

                <div class="relative overflow-hidden">
                    <a href="{{ route('book.event', $event) }}" class="block overflow-hidden">
                        {{ $event->getFirstMedia('images')?->img()->attributes([
                            'alt' => $event->name,
                            'class' => 'aspect-video w-full bg-gray-100 object-cover transition-transform duration-300 group-hover:scale-105',
                        ]) }}
                    </a>
                    <div class="absolute inset-0 h-full w-full bg-[linear-gradient(135deg,rgba(7,7,7,0)_0%,rgba(7,7,7,0.15)_100%)]"></div>
                </div>

                <div class="relative z-10 p-6 sm:p-8">
                    <h3 class="font-heading text-[clamp(1.3rem,4vw,1.8rem)] font-black uppercase leading-tight tracking-tight text-black">
                        <a href="{{ route('book.event', $event) }}" class="hover:text-[#ff6fa9] transition-colors">
                            {{ $event->name }}
                        </a>
                    </h3>
                    
                    <p class="mt-4 line-clamp-2 text-sm leading-relaxed text-black/70">{{ Str::of(strip_tags($event->description))->before('.')->limit(150) }}.</p>

                    <div class="mt-6 flex items-baseline gap-x-2">
                        <span class="text-2xl font-black text-black">@currency($event->currency->value){{ $event->amount }}</span>
                        <span class="text-xs font-black uppercase tracking-widest text-black/50">per ticket</span>
                    </div>

                    <a href="{{ route('book.event', $event) }}" class="mt-6 block rounded-full border-3 border-black bg-[#ff6fa9] px-6 py-3 text-center text-xs font-black uppercase tracking-widest text-white transition-all duration-200 hover:shadow-[6px_6px_0_0_#171717] active:shadow-[2px_2px_0_0_#171717]">Purchase Tickets</a>

                    @if ($event->upgrade)
                        <div class="mt-6 border-t-2 border-black/10 pt-6">
                            <h4 class="font-heading text-[clamp(1.1rem,3vw,1.4rem)] font-black uppercase tracking-tight text-black">
                                {{ $event->upgrade->title }} Upgrade
                            </h4>
                            @if ($event->upgrade->includes)
                            <ul role="list" class="mt-4 space-y-2 text-xs leading-6 text-black/70">
                                @foreach ($event->upgrade->includes as $include)
                                <li class="flex gap-x-2">
                                    <span class="text-[#ffd54a]">+</span>
                                    {{ data_get($include, 'fields.description') }}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        
                            <div class="mt-4 flex items-baseline gap-x-2">
                                <span class="text-xl font-black text-black">@currency($event->currency->value){{ $event->amount + $event->upgrade->amount }}</span>
                            </div>

                            <a href="{{ route('book.event', [$event, 'upgrade' => $event->upgrade->id]) }}" class="mt-4 block rounded-full border-3 border-black bg-[#7fe7ff] px-6 py-3 text-center text-xs font-black uppercase tracking-widest text-black transition-all duration-200 hover:shadow-[6px_6px_0_0_#171717] active:shadow-[2px_2px_0_0_#171717]">Get Upgrade</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>