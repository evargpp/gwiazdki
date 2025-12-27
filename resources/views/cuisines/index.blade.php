<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Rodzaje kuchni</h2>
    </x-slot>

    <div class="p-6">
        @auth
            <a href="{{ route('cuisines.create') }}"
               class="bg-green-600 text-black px-4 py-2 rounded">
                Dodaj rodzaj kuchni
            </a>
        @endauth

        <ul class="mt-6 space-y-2">
            @foreach($cuisines as $cuisine)
                <li class="flex justify-between border p-3 rounded">
                    <span>{{ $cuisine->name }}</span>

                    @auth
                        <div class="flex gap-2">
                            <a href="{{ route('cuisines.edit', $cuisine) }}"
                               class="text-blue-600">Edytuj</a>

                            <form method="POST"
                                  action="{{ route('cuisines.destroy', $cuisine) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600"
                                        onclick="return confirm('Usunąć?')">
                                    Usuń
                                </button>
                            </form>
                        </div>
                    @endauth
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
