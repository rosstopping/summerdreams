<x-layouts.app>
    <x-page-header image="{{ Vite::asset('resources/images/357826990_657385816431795_986628924903999417_n.jpg') }}">
        <x-slot:title>
        Thanks for getting in touch!
        </x-slot>
        We've received your message and will get back to you as soon as possible.
    </x-page-header>
    @if(session('contact_form_submission'))
    @push('scripts')
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'vvip_conversion',
                conversion_type: '{{ session('contact_form_submission.conversion_type') }}',
                user_data: {
                    email: '{{ session('contact_form_submission.email') ?? "" }}',
                    phone_number: '{{ session('contact_form_submission.phone') ?? "" }}'
                }
            });
        </script>
    @endpush
    @endif
</x-layouts.app>
