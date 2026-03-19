<div data-sal="slide-up"
  data-sal-delay="100"
  data-sal-duration="1000"
  data-sal-easing="ease-out">
    <div x-data="{ shown: false }" x-intersect="shown = true" class="mx-auto mt-3 max-w-6xl font-heading font-black tracking-tight
    @switch($size)
        @case('sm')

            text-xl md:max-w-4xl md:text-2xl

            @break
        @case('xl')

            text-4xl md:max-w-5xl md:text-7xl

            @break
    
        @default
            text-3xl md:max-w-5xl md:text-5xl
    @endswitch">
        <div class="relative inline-block uppercase">
            <span class="block text-center [text-wrap:balance]  bg-clip-text leading-normal text-transparent drop-shadow-[0_1px_0_rgba(23,23,23,0.2)] md:leading-tight tracking-normal 
    
            @switch($style)
                @case('white')

                    bg-gradient-to-b from-white to-brand-light

                    @break
            
                @default
                    bg-gradient-to-b from-brand to-brand-dark
            @endswitch">{{ $slot }}</span>
        </div>
    </div>
</div>