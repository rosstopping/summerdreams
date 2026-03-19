<x-mail::message>
# {{ config('app.name') }}

>## Your export is ready to download


<x-mail::button :url="$export">
Download Export
</x-mail::button>

Click the button above or visit the [Admin system]({{ config('app.url') . '/admin' }}) and see your notifications to download the export.
</x-mail::message>
