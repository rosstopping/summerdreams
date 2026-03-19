<div x-data="{ animate: false }" x-intersect="animate = true" {{-- x-bind:class="animate ? 'scale-100 opacity-100 w-full' : 'scale-150 opacity-0 w-0'" --}} class="transition-all ease-in-out duration-1000 delay-300">
    <div class="px-4">
        <div class=" h-96 bg-no-repeat md:bg-fixed bg-cover" style="background-image: url('{{ Storage::url(data_get($content, 'image')) }}');">
        </div>
        {{-- <div class="absolute top-0 left-0 w-full bg-linear-to-b from-white h-[80%]"></div> --}}
        {{-- <div class="absolute bottom-0 left-0 w-full bg-linear-to-t from-white h-[80%]"></div> --}}
    </div>
</div>