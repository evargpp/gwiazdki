<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edytuj rodzaj kuchni</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('cuisines.update', $cuisine) }}">
            @csrf
            @method('PUT')

            <input type="text" name="name"
                   value="{{ $cuisine->name }}"
                   class="border p-2 w-full"
                   required>

            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Zapisz zmiany
            </button>
        </form>
    </div>
</x-app-layout>
