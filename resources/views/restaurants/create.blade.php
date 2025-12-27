<x-app-layout>
  <x-slot name="header">Dodaj restaurację</x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 gap-6 mt-6">

    @if ($errors->any())
      <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        <label class="font-semibold">Błędy:</label>
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('restaurants.store') }}">
      @csrf

      <label class="font-semibold">Nazwa:</label>
      <input name="name" value="{{ old('name', $restaurant->name ?? '') }}" class="w-full border rounded p-2 mb-4"
        placeholder="Nazwa">

      <label class="font-semibold">Adres restauracji:</label>
      <input name="address" value="{{ old('address', $restaurant->address ?? '') }}"
        class="w-full border rounded p-2 mb-4" placeholder="Adres">

      <label class="font-semibold">Plik ze zdjęciem</label><br>
      <input type="file" name="image"">

      <div class="mt-4">
        <label class="font-semibold mt-4">Rodzaje kuchni</label>
        @foreach ($cuisines as $cuisine)
          <div>
            <input type="checkbox" name="cuisines[]" value="{{ $cuisine->id }}" @checked(isset($restaurant) && $restaurant->cuisines->contains($cuisine))>
            {{ $cuisine->name }}
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        <div>
          <label for="latitude" class="block font-semibold mb-1">Szerokość geograficzna (lat)</label>
          <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
            class="w-full border rounded px-3 py-2 @error('latitude') border-red-500 @enderror">

        </div>
        <div>
          <label for="longitude" class="block font-semibold mb-1">Długość geograficzna (lng)</label>
          <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
            class="w-full border rounded px-3 py-2 @error('longitude') border-red-500 @enderror">
        </div>
      </div>

      <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
        Zapisz
      </button>
    </form>
  </div>
</x-app-layout>
