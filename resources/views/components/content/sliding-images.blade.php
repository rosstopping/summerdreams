<section class="relative isolate mx-auto w-full py-12 overflow-hidden">
    <div class="scrollbar-hide group mb-6 w-full">
        <div x-data="scroller" @scroll.window="onScroll" class="relative h-full w-max">
            <div class="grid h-full w-full grid-flow-col items-stretch gap-6">
                @foreach ($content->getMedia('images') as $slide)
                    {{
                        $slide->img()->attributes([
                            'class' => 'h-64 w-auto ',
                        ])
                    }}
                @endforeach
                @foreach ($content->getMedia('images') as $slide)
                    {{
                        $slide->img()->attributes([
                            'class' => 'h-64 w-auto ',
                        ])
                    }}
                @endforeach
            </div>
        </div>
    </div>
</section>