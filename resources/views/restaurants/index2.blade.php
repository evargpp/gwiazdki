<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Restauracje</h2>
  </x-slot>

  <div class="py-6 max-w-7xl mx-auto">
    <a href="{{ route('restaurants.create') }}" class="mb-4 inline-block bg-indigo-600 text-black px-4 py-2 rounded">
      + Dodaj restaurację
    </a>

    <form method="GET" action="{{ route('restaurants.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
      {{-- Rodzaje kuchni --}}
      <div>
        <label class="block text-sm font-medium">Kuchnia</label>
        <select name="cuisines[]" multiple class="border p-2 rounded">
          @foreach ($allCuisines as $cuisine)
            <option value="{{ $cuisine->id }}"
              {{ in_array($cuisine->id, request()->get('cuisines', [])) ? 'selected' : '' }}>
              {{ $cuisine->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Ocena od --}}
      <div>
        <label class="block text-sm font-medium">Ocena od</label>
        <input type="number" name="rating_from" min="0" max="5" step="0.1"
          value="{{ request()->rating_from ?? '0' }}" class="border p-2 rounded w-20">
      </div>

      {{-- Ocena do --}}
      <div>
        <label class="block text-sm font-medium">Ocena do</label>
        <input type="number" name="rating_to" min="1" max="5" step="0.1"
          value="{{ request()->rating_to ?? '5' }}" class="border p-2 rounded w-20">
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">
        Filtruj
      </button>
    </form>

    <table class="w-full bg-white shadow rounded">
      <thead>
        <tr class="border-b">
          <th class="p-2 text-left"><a
              href="{{ route('restaurants.index', [
                  'sort' => 'name',
                  'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc',
              ]) }}">
              Nazwa
              @if ($sort === 'name')
                {{ $direction === 'asc' ? '↑' : '↓' }}
              @endif
            </a></th>
          <th class="p-2 text-left">Kuchnie</th>
          <th class="p-2 text-left">Opinie</th>
          <th class="p-2 text-left">Akcje</th>
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
            <td class="p-2">
              <div class="mt-4 flex items-center text-yellow-400">
                @php
                  $avg = round($restaurant->averageRating());
                @endphp

                {{-- Gwiazdki --}}
                @for ($i = 1; $i <= 5; $i++)
                  <span class="{{ $i <= $avg ? '' : 'text-gray-300' }}">
                    ★
                  </span>
                @endfor

                {{-- Liczba w nawiasie --}}
                <span class="ml-2 text-sm text-gray-600">
                  ({{ number_format($restaurant->averageRating(), 1) }}
                  /
                  {{ $restaurant->reviews()->count() }} opinii)
                </span>
              </div>
            </td>
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
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">
      {{ $restaurants->links() }}
    </div>
  </div>
</x-app-layout>
