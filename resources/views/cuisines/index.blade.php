<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Rodzaje kuchni</h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 gap-6 mt-6">
    <a href="{{ route('cuisines.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
      Dodaj
    </a>

    <table class="table-fixed w-full bg-white shadow rounded border border-gray-300 mt-4">
      <thead>
        <tr class="border-b">
          <th class="border p-2 text-left" style="width: 90%">
            Nazwa kuchni
          </th>
          @auth
            <th class="border p-2 text-left">Akcje</th>
          @endauth
        </tr>
      </thead>
      <tbody>
        @foreach ($cuisines as $cuisine)
          <tr class="border-b">
            <td class="p-2">{{ $cuisine->name }}</td>
            @auth
              <td class="p-2">
                <div class="flex gap-2">
                  <a href="{{ route('cuisines.edit', $cuisine) }}" class="text-blue-600">Edytuj</a>

                  <form method="POST" action="{{ route('cuisines.destroy', $cuisine) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600" onclick="return confirm('Usunąć?')">
                      Usuń
                    </button>
                  </form>
                </div>
              </td>
            @endauth
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-app-layout>
