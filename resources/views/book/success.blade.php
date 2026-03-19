<x-layouts.app>
    <x-page-header image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        Thanks for booking!
        </x-slot>
        You'll shortly receive an email confirming your booking & payment. Contact us if you have any questions regarding your booking.
    </x-page-header>
    @push('scripts')
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                'event': 'vvip_conversion',
                'conversion_type': 'booking'
            });
        </script>
    @endpush
</x-layouts.app>
