@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full h-10 text-gray-900 placeholder-transparent bg-transparent border-t-0 border-l-0 border-r-0 border-blue-300 border-b-1 peer placeholder:ml-2 focus:outline-none focus:ring-0']) !!}>
