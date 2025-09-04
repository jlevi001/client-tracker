@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    {{-- Modal Title --}}
    <h3 class="font-bold text-lg text-base-content">
        {{ $title }}
    </h3>
    
    {{-- Modal Content --}}
    <div class="py-4 text-base-content/70">
        {{ $content }}
    </div>
    
    {{-- Modal Actions --}}
    <div class="modal-action">
        {{ $footer }}
    </div>
</x-modal>