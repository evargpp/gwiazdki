<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dodaj rodzaj kuchni</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('cuisines.store') }}">
            @csrf

            <input type="text" name="name"
                   class="border p-2 w-full"
                   placeholder="np. Włoska"
                   required>

            <button class="mt-4 bg-green-600 text-black px-4 py-2 rounded">
                Zapisz
            </button>
        </form>
    </div>
</x-app-layout>
