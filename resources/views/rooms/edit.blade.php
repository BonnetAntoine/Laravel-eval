<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la salle') }} - {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('rooms.update', $room) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nom de la salle -->
                        <div class="mb-4">
                            <x-input-label for="nom" :value="__('Nom de la salle')" />
                            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom', $room->nom)" required autofocus />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <!-- Capacité -->
                        <div class="mb-4">
                            <x-input-label for="capacite" :value="__('Capacité (nombre de personnes)')" />
                            <x-text-input id="capacite" class="block mt-1 w-full" type="number" name="capacite" :value="old('capacite', $room->capacite)" min="1" required />
                            <x-input-error :messages="$errors->get('capacite')" class="mt-2" />
                        </div>

                        <!-- Surface -->
                        <div class="mb-4">
                            <x-input-label for="surface" :value="__('Surface (m²)')" />
                            <x-text-input id="surface" class="block mt-1 w-full" type="number" step="0.01" name="surface" :value="old('surface', $room->surface)" />
                            <x-input-error :messages="$errors->get('surface')" class="mt-2" />
                        </div>

                        <!-- Équipements -->
                        <div class="mb-4">
                            <x-input-label for="equipment" :value="__('Équipements disponibles')" />
                            <textarea id="equipment" name="equipment" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('equipment', $room->equipment) }}</textarea>
                            <x-input-error :messages="$errors->get('equipment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
