@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'lg:text-sm font-semibold leading-6 text-gray-900 border-b-2 border-indigo-400 transition duration-150 ease-in-out'
                : 'lg:text-sm font-semibold leading-6 text-gray-900 border-b-2 border-transparent hover:border-indigo-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>