@csrf

<div class="space-y-4">
    <input name="name" value="{{ old('name', $restaurant->name ?? '') }}"
           class="w-full border rounded p-2" placeholder="Nazwa">

    <input name="address" value="{{ old('address', $restaurant->address ?? '') }}"
           class="w-full border rounded p-2" placeholder="Adres">

    <input type="file" name="image">

    <div>
        <label class="font-semibold">Rodzaje kuchni</label>
        @foreach($cuisines as $cuisine)
            <div>
                <input type="checkbox"
                       name="cuisines[]"
                       value="{{ $cuisine->id }}"
                       @checked(isset($restaurant) && $restaurant->cuisines->contains($cuisine))>
                {{ $cuisine->name }}
            </div>
        @endforeach
    </div>

    <button class="bg-indigo-600 text-black px-4 py-2 rounded">
        Zapisz
    </button>
</div>
