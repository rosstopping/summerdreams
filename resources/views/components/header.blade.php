<script>
const header = () => ({
    showMenu: false,
    scrolled: false,
    subMenu: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = pageYOffset > 80;
        });
    }
});

</script>
<div x-data="header" x-cloak>
    <div class="fixed inset-x-0 top-0 z-50 px-4 pt-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            {{-- <div aria-hidden="true" x-show="!scrolled" x-transition.opacity class="pointer-events-none absolute left-0 top-0 hidden h-20 w-20 -translate-x-3 -translate-y-2 rounded-full border-4 border-black bg-[#ffd54a] lg:block"></div>
            <div aria-hidden="true" x-show="!scrolled" x-transition.opacity class="pointer-events-none absolute right-16 top-3 hidden h-12 w-12 rotate-12 rounded-[1rem] border-4 border-black bg-[#7fe7ff] lg:block"></div> --}}

            <div x-bind:class="scrolled ? 'bg-[#fff7ef]/96 shadow-[0_14px_30px_rgba(0,0,0,0.16)]' : 'bg-[#fff7ef]/92 shadow-[10px_10px_0_0_#171717]'" class="relative rounded-[2rem] border-4 border-black backdrop-blur-md transition-all duration-300">
                <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-7">
                    <div class="flex items-center gap-3 lg:gap-5">
                        <a href="/" class="shrink-0">
                            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto sm:h-14" />
                        </a>
                        {{-- <div class="hidden xl:flex items-center gap-2 rounded-full border-2 border-black bg-[#111111] px-4 py-2 text-[0.65rem] font-black uppercase tracking-[0.24em] text-white">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#ffd54a]"></span>
                            Ayia Napa 2026
                        </div> --}}
                    </div>

                    <div class="hidden lg:flex items-center gap-2 xl:gap-3">
                        @foreach (menu('header') as $item)
                            @if ($item['children']->count() > 0)
                                <div class="relative group z-20">
                                    <div class="flex cursor-pointer items-center gap-2 rounded-full px-4 py-3 text-[0.72rem] font-black uppercase tracking-[0.16em] text-black transition-colors duration-200 hover:bg-[#ff6fa9] hover:text-white xl:text-xs">
                                        <a href="{{ $item['value'] }}">{{ $item['name'] }}</a>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="absolute left-0 top-full z-20 hidden w-64 pt-3 group-hover:block">
                                        <div class="grid gap-2 rounded-[1.5rem] border-4 border-black bg-white p-3 shadow-[8px_8px_0_0_#171717]">
                                            @foreach ($item['children'] as $item)
                                                <a href="{{ $item['value'] }}" class="rounded-[1rem] border-2 border-transparent px-4 py-3 text-sm font-black uppercase tracking-[0.12em] text-black transition-all duration-200 hover:border-black hover:bg-[#7fe7ff]">{{ $item['name'] }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $item['value'] }}" class="rounded-full px-4 py-3 text-[0.72rem] font-black uppercase tracking-[0.16em] text-black transition-colors duration-200 hover:bg-[#ff6fa9] hover:text-white xl:text-xs">{{ $item['name'] }}</a>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2 sm:gap-3">
                        @if (!session('booking'))
                            <a href="/login/" class="hidden items-center gap-2 rounded-full border-2 border-black bg-white px-4 py-3 text-[0.68rem] font-black uppercase tracking-[0.16em] text-black transition-transform duration-200 hover:-translate-y-0.5 md:flex xl:text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 xl:h-5 xl:w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Login
                            </a>
                        @else
                            <a href="/logout/" class="hidden items-center gap-2 rounded-full border-2 border-black bg-white px-4 py-3 text-[0.68rem] font-black uppercase tracking-[0.16em] text-black transition-transform duration-200 hover:-translate-y-0.5 md:flex xl:text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 xl:h-5 xl:w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                </svg>
                                Logout
                            </a>
                        @endif

                        <a href="{{ Request::path() === 'reserve' ? '#book' : '/book' }}" class="hidden items-center justify-center rounded-full border-2 border-black bg-brand px-5 py-3 text-[0.72rem] font-black uppercase tracking-[0.16em] text-black transition-transform duration-200 hover:-translate-y-0.5 lg:inline-flex xl:px-6 xl:text-xs">
                            Book Tickets
                        </a>

                        <button x-on:click="showMenu = true" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ff6fa9] p-3 text-white transition-transform duration-200 hover:-translate-y-0.5 lg:hidden">
                            <span class="sr-only">Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showMenu" x-transition.opacity class="fixed inset-0 z-[60] bg-black/55 backdrop-blur-sm"></div>

    <div x-bind:class="showMenu ? 'translate-x-0' : 'translate-x-full'" class="fixed inset-y-0 right-0 z-[70] w-full max-w-md transition-transform duration-300 ease-out sm:max-w-lg">
        <div class="relative flex h-full flex-col overflow-hidden border-l-4 border-black bg-[#fff7ef]">
            <div aria-hidden="true" class="absolute -left-8 top-20 h-24 w-24 rounded-full border-4 border-black bg-[#ffd54a]"></div>
            <div aria-hidden="true" class="absolute right-6 top-28 h-14 w-14 rotate-12 rounded-[1rem] border-4 border-black bg-[#7fe7ff]"></div>
            <div aria-hidden="true" class="absolute bottom-10 right-10 h-20 w-20 rounded-[1.5rem] border-4 border-black bg-[#ff6fa9]"></div>

            <div class="relative flex items-center justify-between border-b-4 border-black px-6 py-5 sm:px-8">
                <div>
                    <p class="text-[0.7rem] font-black uppercase tracking-[0.24em] text-black/55">Summer Dreams</p>
                    <p class="mt-2 font-heading text-3xl font-black uppercase leading-none text-black">Menu</p>
                </div>
                <button x-on:click="showMenu = false; subMenu = false" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-white p-3 text-black">
                    <span class="sr-only">Close menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="relative flex-1 overflow-y-auto px-6 py-6 sm:px-8">
                <template x-if="!subMenu">
                    <div>
                        <div class="space-y-3">
                            @foreach (menu('header') as $item)
                                @if ($item['children']->count() > 0)
                                    <button x-on:click="subMenu = '{{ $item['name'] }}'" class="flex w-full items-center justify-between rounded-[1.4rem] border-4 border-black bg-white px-5 py-4 text-left shadow-[6px_6px_0_0_#171717]">
                                        <span class="text-sm font-black uppercase tracking-[0.16em] text-black">{{ $item['name'] }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </button>
                                @else
                                    <a href="{{ $item['value'] }}" class="flex items-center rounded-[1.4rem] border-4 border-black bg-white px-5 py-4 text-sm font-black uppercase tracking-[0.16em] text-black shadow-[6px_6px_0_0_#171717]">{{ $item['name'] }}</a>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-8 grid gap-3">
                            <a href="/book" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-6 py-4 text-sm font-black uppercase tracking-[0.18em] text-black">Book Now</a>
                            <a href="https://api.whatsapp.com/send?phone=+447956088925&amp;text=Hey!" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#7fe7ff] px-6 py-4 text-sm font-black uppercase tracking-[0.18em] text-black">Chat On WhatsApp</a>
                            @if (!session('booking'))
                                <a href="/login/" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-white px-6 py-4 text-sm font-black uppercase tracking-[0.18em] text-black">Manage Booking</a>
                            @else
                                <a href="/logout/" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-white px-6 py-4 text-sm font-black uppercase tracking-[0.18em] text-black">Logout</a>
                            @endif
                        </div>
                    </div>
                </template>

                <template x-if="subMenu">
                    <div>
                        <button x-on:click="subMenu = false" class="mb-5 inline-flex items-center gap-2 rounded-full border-2 border-black bg-white px-4 py-3 text-xs font-black uppercase tracking-[0.16em] text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                            Back
                        </button>

                        @foreach (menu('header') as $item)
                            @if ($item['children']->count() > 0)
                                <div x-show="subMenu === '{{ $item['name'] }}'" x-transition.opacity>
                                    <p class="mb-4 text-[0.7rem] font-black uppercase tracking-[0.24em] text-black/55">{{ $item['name'] }}</p>
                                    <div class="space-y-3">
                                        @foreach ($item['children'] as $item)
                                            <a href="{{ $item['value'] }}" class="flex items-center rounded-[1.4rem] border-4 border-black bg-white px-5 py-4 text-sm font-black uppercase tracking-[0.16em] text-black shadow-[6px_6px_0_0_#171717]">{{ $item['name'] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>