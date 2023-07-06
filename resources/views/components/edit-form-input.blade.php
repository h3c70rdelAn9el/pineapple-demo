@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "w-full rounded-md border border-blue-200 bg-gray-50 py-1 px-3 text-base text-gray-600 outline-none focus:border-blue-500 focus:shadow-md font-normal"]) !!}>
