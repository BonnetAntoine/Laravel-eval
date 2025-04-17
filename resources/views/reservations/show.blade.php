<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la réservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-xl font-bold text-gray-800">{{ $reservation->titre }}</h3>
                                <div class="mt-4 space-y-2">
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Salle:</span> {{ $reservation->room->nom }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Date:</span> {{ $reservation->debut->format('d/m/Y') }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Horaire:</span> {{ $reservation->debut->format('H:i') }} - {{ $reservation->fin->format('H:i') }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Durée:</span> {{ $reservation->duree }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Réservé par:</span> {{ $reservation->user->nom }} {{ $reservation->user->prenom }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Statut:</span>
                                        @if($reservation->is_cancelled)
                                            <span class="px-2 py-1 text-xs font-semibold leading-none text-red-800 bg-red-100 rounded-full">Annulée</span>
                                        @elseif($reservation->isPast())
                                            <span class="px-2 py-1 text-xs font-semibold leading-none text-gray-800 bg-gray-100 rounded-full">Terminée</span>
                                        @elseif($reservation->isInProgress())
                                            <span class="px-2 py-1 text-xs font-semibold leading-none text-green-800 bg-green-100 rounded-full">En cours</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold leading-none text-blue-800 bg-blue-100 rounded-full">À venir</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2">
                                @if(!$reservation->is_cancelled && $reservation->isUpcoming())
                                    @if(auth()->user()->id === $reservation->user_id || auth()->user()->isA('admin'))
                                        <a href="{{ route('reservations.edit', $reservation) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <i class="fas fa-edit mr-2"></i> {{ __('Modifier') }}
                                        </a>

                                        <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                            @csrf
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="fas fa-times-circle mr-2"></i> {{ __('Annuler') }}
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <a href="{{ route('reservations.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Retour') }}
                                </a>
                            </div>
                        </div>

                        @if($reservation->description)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-2">Description:</h4>
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $reservation->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr class="my-6">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations sur la salle</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">
                                    <span class="font-semibold">Nom:</span> {{ $reservation->room->nom }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-semibold">Capacité:</span> {{ $reservation->room->capacite }} personnes
                                </p>
                                @if($reservation->room->surface)
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Surface:</span> {{ $reservation->room->surface }} m²
                                    </p>
                                @endif
                            </div>
                            <div>
                                @if($reservation->room->equipment)
                                    <p class="text-gray-600">
                                        <span class="font-semibold">Équipements:</span><br>
                                        {{ $reservation->room->equipment }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
