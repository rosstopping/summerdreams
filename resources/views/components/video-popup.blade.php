<div x-data="{open: false, id: '{{ $id }}'}">
    <button x-on:click="open = true">{{ $slot }}</button>
    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 w-full h-full bg-black bg-opacity-50 z-50 p-12 flex justify-center items-center">
            <div class="z-50 absolute top-0 left-0 w-full pt-6 flex justify-center items-center">
                <button x-on:click="open = false" class="bg-black text-white  py-2 px-3 flex justify-center items-center text-sm">Exit video <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <iframe x-bind:src="open ? 'https://www.youtube.com/embed/' + id : ''" class="w-full h-full max-h-screen max-w-6xl aspect-video"></iframe>
        </div>
    </template>
</div>