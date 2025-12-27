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

    {{-- autor --}}
    <div>
      <span class="font-semibold text-gray-700">Autor:</span>
      <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">{{ $restaurant->user->name }}</span>
    </div>

    {{-- gps --}}
    <div>
      <span class="font-semibold text-gray-700">GPS:</span>
      @if ($restaurant->latitude && $restaurant->longitude)
        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
          {{ $restaurant->latitude }}, {{ $restaurant->longitude }}
        </span>
        <a href="https://www.openstreetmap.org/?mlat={{ $restaurant->latitude }}&mlon={{ $restaurant->longitude }}&zoom=16"
          target="_blank" class="text-blue-600 hover:underline">
          Pokaż na mapie
        </a>
      @else
        <span class="text-gray-500">Brak danych GPS</span>
      @endif
    </div>

    {{-- data --}}
    <div>
      <span class="font-semibold text-gray-700">Data utworzenia/modyfikacji:</span>
      <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
        {{ $restaurant->created_at->format('d.m.Y') }} /
        {{ $restaurant->updated_at->format('d.m.Y') }}
      </span>
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

    {{-- Opinia użytkownika --}}
    @auth
      @if ($userReview)
        <div>
          <h2 class="font-semibold text-gray-700">Twoja opinia i komentarz</h2>
          <div class="border p-4 rounded-lg">
            <div class="flex items-center justify-between mb-2">
              <span class="font-semibold">Użytkownik: {{ Auth::user()->name }} </span>
              <span class="text-yellow-500">Opinia:
                @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= $userReview->rating)
                    ★
                  @else
                    ☆
                  @endif
                @endfor
              </span>
            </div>
            @if ($userReview->comment)
              Komentarz:<br>
              <p class="text-gray-700">{{ $userReview->comment }}</p>
            @endif
            <i>Data dodania: {{ $userReview->created_at->format('d.m.Y') }}</i>
          </div>
          <form action="{{ route('restaurants.reviews.destroy', [$restaurant, $userReview]) }}" method="POST"
            class="mt-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
              onclick="return confirm('Na pewno chcesz usunąć opinię?')">
              Usuń
            </button>
          </form>
        </div>
      @else
        <div>
          <h2 class="font-semibold text-gray-700">Twoja opinia i komentarz</h2>
          <form action="{{ route('reviews.store', $restaurant) }}" method="POST" class="mt-6 space-y-4">
            @csrf
            {{-- Ocena w skali 1-5 --}}
            <div>
              <label class="block mb-1 font-medium text-gray-700">Ocena:</label>
              <select name="rating" class="border rounded px-3 py-2 w-32">
                <option value="1">★</option>
                <option value="2">★★</option>
                <option value="3">★★★</option>
                <option value="4">★★★★</option>
                <option value="5">★★★★★</option>
              </select>
            </div>

            {{-- Komentarz --}}
            <div>
              <label class="block mb-1 font-medium text-gray-700">Komentarz:</label>
              <textarea name="comment" rows="3" class="border rounded w-full px-3 py-2"></textarea>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Dodaj
              opinię</button>
          </form>


        </div>
      @endif
    @endauth

    {{-- Lista opinii --}}
    <div>
      <h2 class="font-semibold text-gray-700">Opinie i komentarze użytkowników</h2>

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
  </div>

</x-app-layout>
