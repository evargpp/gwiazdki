<x-app-layout>
    <x-slot name="header">Dodaj restaurację</x-slot>

    <form method="POST" enctype="multipart/form-data"
          action="{{ route('restaurants.store') }}"
          class="max-w-xl mx-auto py-6">
        @include('restaurants._form')
    </form>
</x-app-layout>