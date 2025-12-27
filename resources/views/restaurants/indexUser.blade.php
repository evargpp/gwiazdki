<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Restauracje</h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 flex flex-row gap-6 mt-6">
    {{-- ▌ Lista restauracji --}}
    <div class="flex-1">
      <a href="{{ route('restaurants.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
        Dodaj
      </a>
      <table class="table-fixed w-full bg-white shadow rounded border border-gray-300 mt-4">
        <thead>
          <tr class="border-b">
            <th class="border p-2 text-left" style="width: 40%">
              Nazwa restauracji
            </th>
            <th class="border p-2 text-left" style="width: 40%">Kuchnie</th>
            <th class="border p-2 text-left" style="width: 20%">Opinie</th>
            @auth
              <th class="border p-2 text-left">Akcje</th>
            @endauth
          </tr>
        </thead>
        <tbody>
          @foreach ($restaurants as $restaurant)
            <tr class="border-b">
              <td class="p-2">
                <a href="{{ route('restaurants.show', $restaurant) }}"
                  class="text-indigo-600">{{ $restaurant->name }}</a>
              </td>
              <td class="p-2">

                @foreach ($restaurant->cuisines as $cuisine)
                  <span
                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                    {{ $cuisine->name }}
                  </span>
                @endforeach
              </td>
              <td class="p-2 text-center">
                <div class="mt-4 flex items-center text-yellow-400">
                  @php
                    $avg = round($restaurant->averageRating());
                  @endphp

                  {{-- Gwiazdki --}}
                  @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $avg)
                      ★
                    @else
                      ☆
                    @endif
                  @endfor

                  {{-- Liczba w nawiasie --}}
                  <span class="ml-2 text-sm text-gray-600">
                    ({{ number_format($restaurant->averageRating(), 1) }}
                    /
                    {{ $restaurant->reviews()->count() }} opinii)
                  </span>
                </div>
              </td>
              @auth
                <td class="p-2 space-x-2">
                  <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-indigo-600">Edytuj</a>

                  <form method="POST" action="{{ route('restaurants.destroy', $restaurant) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600" onclick="return confirm('Usunąć?')">
                      Usuń
                    </button>
                  </form>
                </td>
              @endauth
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</x-app-layout>
