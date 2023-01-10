@props(['value'])

{{-- <label {{ $attributes->merge(['class' => 'absolute left-1 -top-3.5 text-xs text-gray-600 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-5 peer-focus:text-sm peer-focus:text-gray-600']) }}>
    {{ $value ?? $slot }}
</label> --}}


<label {{ $attributes->merge(['class' => "mb-3 block text-sm mb-1 font-medium text-gray-400"]) }}>
    {{ $value ?? $slot }}
</label>
