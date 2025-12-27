<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">{{ $restaurant->name }}</h2>
  </x-slot>

  <div class="max-w-7xl mx-auto bg-white shadow rounded-lg p-6 space-y-6 mt-2">

    {{-- Adres --}}
    <div>
      <span class="font-semibold text-gray-700">Adres:</span>
      <span class="text-gray-600">{{ $restaurant->address }}</span>
    </div>

    {{-- Rodzaje kuchni --}}
    <div>
      <span class="font-semibold text-gray-700">Kuchnie:</span>
      <div class="flex flex-wrap gap-2">
        @foreach ($restaurant->cuisines as $cuisine)
          <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $cuisine->name }}</span>
        @endforeach
      </div>
    </div>

    {{-- Średnia ocena --}}
    <div>
      <span class="font-semibold text-gray-700">Opinie:</span>

      @php
        $avg = round($restaurant->averageRating());
      @endphp

      @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $avg)
          ★
        @else
          ☆
        @endif
      @endfor


      <span class="ml-2 text-sm text-gray-600">
        ({{ number_format($restaurant->averageRating(), 1) }}
        /
        {{ $restaurant->reviews()->count() ?? 'brak' }} opinii)
      </span>


      {{-- Zdjęcie --}}
      @if ($restaurant->image)
        <div>
          <span class="font-semibold text-gray-700">Zdjęcie:</span>
          <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" style="height: 200px">
        </div>
      @endif

      @foreach ($restaurant->cuisines as $cuisine)
        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $cuisine->name }}</span>
      @endforeach

    </div>


    {{-- Lista opinii --}}
    <div>
      <h2 class="font-semibold text-gray-700">Komentarze użytkowników</h2>

      @forelse($restaurant->reviews as $review)
        <div class="border p-4 rounded-lg">
          <div class="flex items-center justify-between mb-2">
            <span class="font-semibold">Użytkownik: {{ $review->user->name }}</span>
            <span class="text-yellow-500">Opinia:
              @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $review->rating)
                  ★
                @else
                  ☆
                @endif
              @endfor
            </span>
          </div>
          @if ($review->comment)
            Komentarz:<br>
            <p class="text-gray-700">{{ $review->comment }}</p>
          @endif
          <i>Data dodania: {{ $review->created_at->format('d.m.Y') }}</i>
        </div>
      @empty
        <p class="text-gray-500">Brak opinii dla tej restauracji.</p>
      @endforelse
    </div>

    {{-- Formularz dodania opinii (jeśli zalogowany) --}}
    @auth
      <form action="{{ route('restaurants.reviews.store', $restaurant) }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <h3 class="text-lg font-semibold text-gray-700">Dodaj opinię</h3>

        {{-- Ocena w skali 1-5 --}}
        <div>
          <label class="block mb-1 font-medium text-gray-700">Ocena:</label>
          <select name="rating" class="border rounded px-3 py-2 w-32">
            @for ($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>

        {{-- Komentarz --}}
        <div>
          <label class="block mb-1 font-medium text-gray-700">Komentarz:</label>
          <textarea name="comment" rows="3" class="border rounded w-full px-3 py-2"></textarea>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Dodaj opinię</button>
      </form>
    @endauth

  </div>

</x-app-layout>
