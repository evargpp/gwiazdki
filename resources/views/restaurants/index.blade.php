<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Restauracje</h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 flex flex-row gap-6 mt-6">

    {{-- ▌ Sidebar --}}
    <aside class="flex-none basis-[50%] bg-white p-4 rounded-lg shadow">
      <form method="GET" action="{{ route('restaurants.index') }}" class="space-y-4">

        {{-- Rodzaje kuchni --}}
        <div>
          <h3 class="text-sm font-semibold mb-2">Kuchnie</h3>
          @foreach ($allCuisines as $cuisine)
            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}"
                {{ in_array($cuisine->id, request()->get('cuisines', [])) ? 'checked' : '' }}
                class="form-checkbox h-4 w-4 text-green-600">
              {{ $cuisine->name }}
            </label>
          @endforeach
        </div>

        {{-- Ocena od --}}
        <div>
          <label class="block text-sm font-medium">Ocena od</label>
          <input type="number" name="rating_from" min="0" max="5" step="0.1"
            value="{{ request()->rating_from ?? '0' }}" class="border p-2 rounded w-full">
        </div>

        {{-- Ocena do --}}
        <div>
          <label class="block text-sm font-medium">Ocena do</label>
          <input type="number" name="rating_to" min="1" max="5" step="0.1"
            value="{{ request()->rating_to ?? '5' }}" class="border p-2 rounded w-full">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 mt-2 rounded">
          Filtruj
        </button>
      </form>
    </aside>

    {{-- ▌ Lista restauracji --}}
    <div class="flex-1">
      <table class="table-fixed w-full bg-white shadow rounded border border-gray-300">
        <thead>
          <tr class="border-b">
            <th class="border p-2 text-left" style="width: 40%">
              <a
                href="{{ route('restaurants.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                Nazwa restauracji
                @if ($sort === 'name')
                  {{ $direction === 'asc' ? '↑' : '↓' }}
                @endif
              </a>

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

      <div class="mt-4">
        {{ $restaurants->links() }}
      </div>


    </div>

  </div>
</x-app-layout>
