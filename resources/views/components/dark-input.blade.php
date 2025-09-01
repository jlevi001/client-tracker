@props(['disabled' => false, 'error' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => $error 
        ? 'w-full px-3 py-2 bg-gray-700 border border-red-500 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-red-500 focus:ring-1 focus:ring-red-500 hover:bg-gray-600 transition-colors duration-200'
        : 'w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200'
]) !!}>