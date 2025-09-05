<li>
    <a {{ $attributes->merge(['class' => 'hover:bg-base-300 active:bg-primary active:text-primary-content']) }}>
        {{ $slot }}
    </a>
</li>