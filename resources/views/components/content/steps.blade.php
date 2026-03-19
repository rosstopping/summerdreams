<div class="relative z-10 pt-20">
    <div class="mx-auto container px-6">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-8 overflow-hidden lg:mx-0 lg:max-w-none lg:grid-cols-4">
            @foreach (data_get($content, 'steps') as $step)
            <div>
                <div class="flex items-center text-sm font-semibold leading-6 text-gray-900">
                    <svg viewBox="0 0 4 4" class="mr-4 h-1 w-1 flex-none" aria-hidden="true">
                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                    </svg>
                    {{ data_get($step, 'attributes.name') }}
                    <div class="absolute -ml-2 h-px w-screen -translate-x-full bg-brand opacity-50 sm:-ml-4 lg:static lg:-mr-6 lg:ml-8 lg:w-auto lg:flex-auto lg:translate-x-0" aria-hidden="true"></div>
                </div>
                <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-brand">{{ data_get($step, 'attributes.title') }}</p>
                <p class="mt-1 text-base leading-7 text-gray-900/75">{{ data_get($step, 'attributes.description') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>