@props(['disabled' => false, 'value' => null, 'name', 'type', 'label'])

@php
    $placeholder = empty($name) ? 'Not provided!!' : '';
@endphp

<div class="my-6">
    <x-form_label for="{{ $name }}">{{ $label }}</x-form_label>
    <x-edit-form-input class="text-gray-700"
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        placeholder='{{ $slot }}'
        {{-- placeholder="{{ ($slot) ?? '' : 'not provided' }}" --}}
        {{-- placeholder="{{ ($slot) ?? '' : 'not provided' }}" --}}
             {{-- @if(empty($name)) --}}
            {{-- placeholder="Not provided" --}}

        {{-- placeholder="{{ ($slot) ?? '' : 'not provided' }}" --}}
        {{-- placeholder="{{ ($slot) ?? '' : 'not provided' }}" --}}
             {{-- @if(empty($name)) --}}
            {{-- placeholder="Not provided" --}}
        @endif
        >
    </x-edit-form-input>
{{-- {{ $slot }}!! --}}
</div>
