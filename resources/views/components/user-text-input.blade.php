<div class="col-span-6 sm:col-span-4">
    <x-jet-label for="{{ $name }}" :value="$label" />
    <x-jet-input
        id="{{ $name }}"
        type="{{ $type }}"
        class="mt-1 block w-full"
        wire:model.defer="{{ $model }}"
        autocomplete="{{ $autocomplete }}"
    />
    <x-jet-input-error for="{{ $name }}" class="mt-2" />
</div>
