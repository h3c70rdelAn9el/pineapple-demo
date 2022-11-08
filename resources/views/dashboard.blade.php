<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <h1 class="text-6xl">la pina</h1>
                <p>welcome {{ $user->name }}</p>
            </div>

            <form
                action="{{ route('patient.store') }}">
                @csrf
                <div>
                    <label for="first"></label>
                    <input type="text" id="first" name="first">
                </div>
                <div>
                    <label for="last"></label>
                    <input type="text" id="last" name="last">
                </div>
                <div>
                    <label for="email"></label>
                    <input type="text" id="email" name="email">
                </div>
                <div>
                    <label for="phone"></label>
                    <input type="text" id="phone" name="phone">
                </div>
                <div>
                    <label for="insurance"></label>
                    <input type="text" id="insurance" name="insurance">
                </div>
                <button type="submit">
                    Add
                </button>

            </form>
        </div>
    </div>
</x-app-layout>
