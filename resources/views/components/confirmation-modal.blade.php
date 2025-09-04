@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="sm:flex sm:items-start">
        {{-- Warning Icon --}}
        <div class="mx-auto shrink-0 flex items-center justify-center size-12 rounded-full bg-error/20 sm:mx-0 sm:size-10">
            <svg class="size-6 text-error" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>

        {{-- Content Section --}}
        <div class="mt-3 text-center sm:mt-0 sm:ms-4 sm:text-start">
            {{-- Modal Title --}}
            <h3 class="text-lg font-bold text-base-content">
                {{ $title }}
            </h3>

            {{-- Modal Content --}}
            <div class="mt-4 text-base-content/70">
                {{ $content }}
            </div>
        </div>
    </div>

    {{-- Modal Actions --}}
    <div class="modal-action">
        {{ $footer }}
    </div>
</x-modal>