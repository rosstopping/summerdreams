<x-layouts.blank>
    <img src="{{ Vite::asset('resources/images/logo-dark.png') }}" alt="{{ config('app.name') }}" class="h-20 my-6 w-auto mx-auto" />
    <div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <form action="{{ route('seller.login') }}" method="POST" class="max-w-xs mx-auto mt-16">
                @csrf
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Login Code</label>
                        <div class="mt-2">
                            <input value="{{ old('code') }}" type="text" name="code" id="code" class="block w-full  border-0 py-1.5 text-gray-900 shadow-xs border-2 border-black placeholder:text-gray-400 focus:border-brand focus:ring-0 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit" class=" bg-brand px-6 py-3 text-sm font-bold text-white border-2 border-black hover:bg-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-1 active:translate-y-1 transition-all uppercase">Login</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.blank>
