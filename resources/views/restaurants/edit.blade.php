<x-app-layout>
    <x-slot name="header">Edytuj restaurację</x-slot>

    <form method="POST" enctype="multipart/form-data"
          action="{{ route('restaurants.update', $restaurant) }}"
          class="max-w-xl mx-auto py-6">
        @method('PUT')
        @include('restaurants._form')
    </form>
</x-app-layout>