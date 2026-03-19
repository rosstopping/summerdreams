<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div
    x-data="{
        value: ['{{ $value }}'],
        init() {
            let picker = flatpickr(this.$refs.picker, {
                dateFormat: 'Y/m/d',
                defaultDate: this.value,
                minDate: '{{ $min }}',
                disableMobile: true
            })

            this.$watch('value', () => picker.setDate(this.value))
        },
    }"
    class="w-full"
>
    <input x-ref="picker" type="text" name="{{ $name }}" {{ $attributes }}>
</div>