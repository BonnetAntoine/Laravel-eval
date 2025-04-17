<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des salles') }}
            </h2>
            @if(auth()->user()->isA('admin'))
            <a href="{{ route('rooms.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i> {{ __('Ajouter une salle') }}
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($rooms->isEmpty())
                        <p class="text-center text-gray-500">{{ __('Aucune salle n\'a été ajoutée pour le moment.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($rooms as $room)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-md">
                                    <div class="p-5">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $room->nom }}</h5>
                                        <div class="mb-4 text-sm text-gray-700">
                                            <p><i class="fas fa-users mr-2"></i> Capacité: {{ $room->capacite }} personnes</p>
                                            @if($room->surface)
                                                <p><i class="fas fa-vector-square mr-2"></i> Surface: {{ $room->surface }} m²</p>
                                            @endif
                                        </div>

                                        @if($room->equipment)
                                            <div class="mb-3">
                                                <h6 class="text-sm font-semibold text-gray-700 mb-1">Équipements:</h6>
                                                <p class="text-sm text-gray-600">{{ $room->equipment }}</p>
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-center mt-4">
                                          <a href="{{ route('rooms.show', $room) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                              <i class="fas fa-info-circle mr-2"></i> Détails
                                          </a>
                                          <div class="flex space-x-2">
                                              <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                                  <i class="fas fa-calendar-plus mr-2"></i> Réserver
                                              </a>

                                              @if(auth()->user()->isA('admin'))
                                                  <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300">
                                                      <i class="fas fa-edit">Editer</i>
                                                  </a>

                                                  <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette salle?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                                                          <i class="fas fa-trash">Supprimer</i>
                                                      </button>
                                                  </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
