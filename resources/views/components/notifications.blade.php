


@if (isset($errors) && $errors->any())
<div class="fixed top-0 right-0 mt-6 mr-8  border border-gray-100 shadow-2xl bg-red-600 p-6 z-50 w-64 md:w-full max-w-sm">

    <div class="flex items-start">
        <div>
            <span class="w-5 h-5 text-green-500 shrink-0"></span>
        </div>
        <div class="flex-1 text-gray-50 tracking-wider px-4">
            {{ $errors->first() }}
        </div>
        <div>
            <button type="button" onClick="window.location.reload();">
                <span class="w-5 h-5 text-gray-50 shrink-0">x</span>
            </button>
        </div>
    </div>
</div>
@endif

@if ($message = Session::get('success'))
<div class="fixed top-0 right-0 mt-6 mr-8  border border-gray-100 shadow-2xl bg-green-600 p-6 z-50 w-64 md:w-full max-w-sm">

    <div class="flex items-start">
        <div>
            <span class="w-5 h-5 text-green-500 shrink-0"></span>
        </div>
        <div class="flex-1 text-gray-50 tracking-wider px-4">
            {{ $message }}
        </div>
        <div>
            <button type="button" onClick="window.location.reload();">
                <span class="w-5 h-5 text-gray-50 shrink-0">x</span>
            </button>
        </div>
    </div>
</div>
@endif

@if ($message = Session::get('status'))
<div class="fixed top-0 right-0 mt-6 mr-8  border border-gray-100 shadow-2xl bg-green-600 p-6 z-50 w-64 md:w-full max-w-sm">

    <div class="flex items-start">
        <div>
            <span class="w-5 h-5 text-green-500 shrink-0"></span>
        </div>
        <div class="flex-1 text-gray-50 tracking-wider px-4">
            {{ $message }}
        </div>
        <div>
            <button type="button" onClick="window.location.reload();">
                <span class="w-5 h-5 text-gray-50 shrink-0">x</span>
            </button>
        </div>
    </div>
</div>
@endif