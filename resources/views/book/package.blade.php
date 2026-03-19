<x-layouts.app>
    <div class=" py-24 sm:py-32 mt-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">@setting('book_package_title', 'Book your event tickets')</p>
            </div>
            <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">@setting('book_package_description', 'Complete the form below to reserve your tickets. Events with selected dates will be based upon your arrival date, you can confirm these dates in the next step.')</p>
            <form action="{{ route('book.submit', $package) }}" method="POST" class="max-w-3xl mx-auto mt-16">
                <x-alerts></x-alerts>
                @csrf
                <input type="hidden" name="type" value="package">
                @include('book.partials.form')
            </form>
        </div>
    </div>
    @if (session('booking_site') !== 'zec')
        <x-newsletter></x-newsletter>
    @endif
</x-layouts.app>
