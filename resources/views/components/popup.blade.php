@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script>
    const popup = () => ({
        viewed: Cookies.get('popup'),
        show: false,
        delay: {{ data_get($popup, 'data.delay', 0) }},
        init() {
            window.setTimeout(() => {
                this.show = true;
                Cookies.set('popup', true)
            }, this.delay * 1000);
        }
    });
    </script>
@endpush
<div x-show="!viewed && show" x-data="popup()" x-init="init()"
    class="fixed inset-0 w-screen h-screen bg-black/75 flex items-center justify-center p-6 z-50"><svg
        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:w-8 md:h-8 text-white fixed top-0 right-0 mt-6 mr-6"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg> <button x-on:click="viewed = true" class="absolute inset-0 w-full h-full appearance-none"></button>
    <div class="grid @if ($popup->getFirstMedia('image')) md:grid-cols-2 max-w-4xl @else max-w-xl @endif w-full bg-white shadow-2xl relative  overflow-hidden">
        <div class="p-6 md:p-12 flex items-center">
            <div>
                <x-ui.title>
                    {{ data_get($popup, 'title') }}
                </x-ui.title>
                {{-- <h2 class="text-2xl md:text-3xl font-display hidden md:block">
                    {{ data_get($popup, 'title') }}
                </h2> --}}
                <div class="prose mt-12 leading-tight">
                    {!! data_get($popup, 'content') !!}
                </div>

                @if ($popup?->flexibleContent)
                    @foreach ($popup->flexibleContent as $content)
                        <x-dynamic-component :component="'content.'.$content->name()" :content="$content"></x-dynamic-component>
                    @endforeach
                @endif
                
                @if (data_get($popup, 'button_text') && data_get($popup, 'button_url'))
                    <a class="mt-6 inline-block  bg-black font-bold text-white hover:bg-white hover:bg-brand hover:text-white transition-all ease-in-out px-8 py-3" href="{{ data_get($popup, 'button_url') }}">{{ data_get($popup, 'button_text') }}</a>
                @endif
            </div>
        </div>
        @if ($popup->getFirstMedia('image'))
            <div class="relative order-first md:order-last">
                <img src="{{ $popup->getFirstMediaUrl('image') }}" alt="{{ data_get($popup, 'title') }}" class="w-full h-40 md:h-full object-cover bg-gray-900">
            </div>
        @endif
    </div>
</div>
