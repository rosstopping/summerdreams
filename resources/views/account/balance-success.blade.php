<x-layouts.app>
    <x-page-header image="/images/zante event packages 2026.jpg">
        <x-slot:title>
        Thanks for your payment!
        </x-slot>
        You'll shortly receive an email confirming your payment. Contact us if you have any questions regarding your booking.
    </x-page-header>
    @if($booking)
    @push('scripts')
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'vvip_purchase',
                conversion_type: 'balance_paid',
                transaction_id: '{{ $stripeTransactionId ?? "" }}',
                value: {{ $booking->balancing_payment_amount ?? 0 }},
                currency: 'GBP',
                user_data: {
                    email: '{{ $booking->email ?? "" }}',
                    phone_number: '{{ $booking->mobile ?? "" }}'
                }
            });
        </script>
    @endpush
    @endif
</x-layouts.app>
