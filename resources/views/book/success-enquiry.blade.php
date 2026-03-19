<x-layouts.app>
    <x-page-header image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
            Great News! 
        </x-slot>
        We have availability for your chosen package and have emailed over a link where you can pay a deposit to complete your booking.
    </x-page-header>
    @push('scripts')
        <script>
            window.dataLayer = window.dataLayer || [];
            @if(session('booking_enquiry_submission'))
            window.dataLayer.push({
                event: 'vvip_conversion',
                conversion_type: 'booking',
                user_data: {
                    email: '{{ session('booking_enquiry_submission.email') ?? "" }}',
                    phone_number: '{{ session('booking_enquiry_submission.phone') ?? "" }}'
                }
            });
            @else
            window.dataLayer.push({
                event: 'vvip_conversion',
                conversion_type: 'booking'
            });
            @endif
        </script>
    @endpush
</x-layouts.app>
