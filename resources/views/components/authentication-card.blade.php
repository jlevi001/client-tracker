<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-200">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 card bg-base-100 shadow-xl overflow-hidden">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>