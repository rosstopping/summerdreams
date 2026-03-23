{{-- newsletter --}}
<div class="px-0">
    <div class="relative mt-6 overflow-hidden bg-gradient-to-br from-yellow-50 via-white to-pink-50">
        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-40 -mt-40"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -ml-40 -mb-40"></div>

        <div class="container mx-auto px-6 relative z-10 py-20 sm:py-28">
            <div class="max-w-2xl">
                <h2 class="text-4xl sm:text-5xl font-black uppercase text-gray-900 leading-tight mb-4">
                    Don't Miss Out
                </h2>
                <p class="text-xl text-gray-700 font-medium mb-8">
                    Get the hottest @setting('year') DJ line-ups, VIP tips, and exclusive discounts straight to your inbox
                </p>

                <form action="{{ route('newsletter') }}" method="POST" class="flex flex-col sm:flex-row gap-4 w-full max-w-lg">
                    @honeypot
                    @csrf
                    <div class="flex-1">
                        <label for="email-address" class="sr-only">Email address</label>
                        <input 
                            id="email-address" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required="" 
                            class="w-full px-6 py-4 bg-white border-3 border-black rounded-2xl text-gray-900 font-semibold placeholder:text-gray-400 shadow-[4px_4px_0px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-all"
                            placeholder="Enter your email">
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-brand hover:bg-brand-dark text-black font-black rounded-2xl border-3 border-black shadow-[4px_4px_0px_rgba(0,0,0,0.15)] hover:shadow-[6px_6px_0px_rgba(0,0,0,0.2)] transition-all cursor-pointer uppercase tracking-tight whitespace-nowrap">
                        Sign Up
                    </button>
                </form>

                <p class="text-sm text-gray-600 mt-4">
                    ✨ No spam, pure summer vibes only
                </p>
            </div>
        </div>

        <img alt="Sign up to our newsletter" class="absolute inset-0 w-full h-full object-cover opacity-20" src="/images/events/vice-parties/IMG_5776.jpg" />
    </div>
</div>
