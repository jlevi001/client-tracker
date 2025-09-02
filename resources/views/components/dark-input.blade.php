@props(['disabled' => false, 'error' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->class([
    'w-full px-3 py-2',
    'bg-gray-700 !bg-gray-700',
    'text-white',
    'placeholder-gray-400', 
    'border rounded-md',
    'transition-colors duration-200',
    'hover:bg-gray-600 hover:!bg-gray-600',
    'focus:bg-gray-600 focus:!bg-gray-600',
    'focus:outline-none focus:ring-1',
    'border-red-500 focus:border-red-500 focus:ring-red-500' => $error,
    'border-gray-600 focus:border-indigo-500 focus:ring-indigo-500' => !$error,
])->merge([
    'style' => 'background-color: rgb(55 65 81) !important; color: white !important;'
]) !!}>