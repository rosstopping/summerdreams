{{-- newsletter --}}
<div class="px-0">
    <div class="bg-black relative mt-6 rounded-none lg: overflow-hidden">
        {{-- <div class="absolute top-0 z-10 h-[75%] w-full bg-linear-to-b from-black to-transparent "></div> --}}
        {{-- <div class="absolute bottom-0 z-10 h-[30%] w-full bg-linear-to-t from-white to-transparent"></div> --}}
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-white py-32 -mt-12">
                <div class="max-w-sm">
                    <x-ui.title style="white" size="sm">Sign up to our Newsletter</x-ui.title>
                </div>
                <form action="{{ route('newsletter') }}" method="POST" class="mt-12 bg-black/75 w-full max-w-md  px-2 py-2">
                    @honeypot
                    @csrf
                    <div class="w-full flex justify-between gap-x-4">
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required="" class="flex-1 bg-transparent appearance-none outline-hidden pl-4 border-none ring-0" placeholder="Enter your email">
                        <button type="submit" class="inline-block  bg-white font-bold text-gray-950 hover:bg-white hover:bg-brand hover:text-white hover:shadow-xl transition-all ease-in-out px-5 py-3 text-sm shrink-0">Sign up</button>
                    </div>
                </form>
                <div class="prose prose-xs max-w-sm text-white opacity-75 mt-4">
                    <p>Get Zante @setting('year') DJ line-up’s, top tips & exclusive discounts via email – sign up now!</p>
                </div>
            </div>
        </div>
        <img alt="Sign up to our newsletter" class="absolute inset-0 w-full h-full object-cover opacity-50" src="/images/events/vice-parties/IMG_5776.jpg" />
    </div>
</div>