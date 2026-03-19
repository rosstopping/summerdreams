<div class="" id="book">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-10 lg:mx-0 @if ($packages->count() === 2) lg:max-w-4xl lg:mx-auto @else lg:max-w-none @endif @if ($packages->count() === 4) lg:grid-cols-2 @endif @if ($packages->count() === 3) lg:grid-cols-3 @endif @if ($packages->count() === 2) lg:grid-cols-2 @endif">
        @foreach ($packages as $package)
        <div class="max-w-lg  p-8 xl:p-10 ring-1 {{ $package->name === 'A-List' ? 'bg-brand-alist text-white' : '' }} {{ $package->name === 'A-List Core' ? 'bg-brand-alistcore text-white' : '' }} {{ $package->featured ? 'bg-brand text-white ring-transparent shadow-xl order-first md:order-none' : 'ring-gray-200' }} {{-- $package->popular ? 'md:scale-110' : '' --}}">
          <div class="flex items-center justify-between gap-x-4">
            <h3 class="text-xl font-semibold leading-8 {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'text-white' : 'text-gray-900' }}">{{ $package->name }}</h3>
            @if ($package->popular)
            <p class=" bg-white/75 px-2.5 py-1 text-xs font-semibold leading-5 text-brand">Most popular</p>
            @endif
        </div>
                <p class="mt-4 text-sm leading-6">{{ $package->description }}</p>
                <p class="mt-6 flex items-baseline gap-x-2">
                    <span class="text-4xl font-bold tracking-tight ">@currency($package->currency->value){{ $package->amount }}</span>
                    @if ($package->deposit)
                        <span class="text-sm font-semibold leading-6 opacity-75">@currency($package->currency->value){{ $package->deposit }} deposit</span>
                    @endif
                </p>
                <a href="{{ route('book.package', $package) }}" aria-describedby="tier-hobby" class="mt-6 block  py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand text-brand ring-1 ring-inset ring-brand hover:scale-105 hover:shadow-2xl transition-all ease-in-out {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'bg-white outline-hidden ring-white' : '' }}">Book Package</a>
                @if ($package->includes)
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 ">
                    @foreach ($package->includes as $include)
                    <li class="flex gap-x-3 {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'text-white' : '' }}">
                        <svg class="h-6 w-5 flex-none {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'text-white' : 'text-brand' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        {{ data_get($include, 'fields.description') }}
                    </li>
                    @endforeach
                </ul>
                @endif
                @if ($package->upgrade)
                    <h4 class="mt-8 text-lg font-semibold leading-8 ">{{ $package->upgrade->title }}</h4>
                    <p class="mt-3 flex items-baseline gap-x-2">
                        <span class="text-4xl font-bold tracking-tight">&pound;{{ $package->amount + $package->upgrade->amount }}</span>
                        @if ($package->upgrade->deposit)
                            <span class="text-sm font-semibold leading-6 opacity-75">&pound;{{ $package->upgrade->deposit }} deposit</span>
                        @endif
                    </p>
                    <a href="{{ route('book.package', [$package, 'upgrade' => $package->upgrade->id]) }}" aria-describedby="tier-hobby" class="mt-6 block  py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand text-brand ring-1 ring-inset ring-brand hover:scale-105 hover:shadow-2xl transition-all ease-in-out  {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'bg-white outline-hidden ring-white' : '' }}">Book {{ $package->upgrade->title }}</a>
                    @if ($package->upgrade->includes)
                    <ul role="list" class="mt-6 space-y-3 text-sm leading-6 text-gray-600 ">
                        @foreach ($package->upgrade->includes as $include)
                        <li class="flex gap-x-3 {{ $package->featured || $package->name === 'A-List' || $package->name === 'A-List Core' ? 'text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5  {{ $package->featured ? 'text-white' : 'text-brand' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                                
                            {{ data_get($include, 'fields.description') }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
