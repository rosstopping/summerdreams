@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
@endpush
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
<style>
    .iti {
        width: 100%;
    }
</style>

<div
    x-data="{
        value: null,
        formatted: null,
        init() {
            let iti = window.intlTelInput(this.$refs.phone, {
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js',
                initialCountry: 'GB',
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                  return 'e.g. ' + selectedCountryPlaceholder;
                },
                preferredCountries: ['gb', 'ie']
            });

            this.$watch('value', () => {
                this.formatted = iti.getNumber();
            })
        },

    }"
    class="w-full"
>
    <input x-model="formatted" name="{{ $name }}" type="hidden" class="hidden" />
    <input x-model="value" x-ref="phone" type="text" {{ $attributes }}>
</div>