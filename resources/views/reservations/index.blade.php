<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-blue-800 leading-tight">
              {{ __('Mes réservations') }}
          </h2>
          <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
              <i class="fas fa-calendar-plus mr-2"></i> {{ __('Nouvelle réservation') }}
          </a>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if(session('success'))
              <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
              </div>
          @endif

          @if(session('error'))
              <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                  <span class="block sm:inline">{{ session('error') }}</span>
              </div>
          @endif

          <!-- Réservations à venir -->
          <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6 bg-blue-50 border-b border-blue-200">
                  <h3 class="text-lg font-semibold text-blue-800 mb-4">Réservations à venir</h3>

                  @if($upcoming->isEmpty())
                      <p class="text-center text-blue-500">{{ __('Vous n\'avez aucune réservation à venir.') }}</p>
                  @else
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-blue-200">
                              <thead class="bg-blue-100">
                                  <tr>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Date</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Horaire</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Salle</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Objet</th>
                                      @if(auth()->user()->isA('admin'))
                                          <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Réservé par</th>
                                      @endif
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Actions</th>
                                  </tr>
                              </thead>
                              <tbody class="bg-blue-50 divide-y divide-blue-200">
                                  @foreach($upcoming as $reservation)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-900">
                                              {{ $reservation->debut->format('d/m/Y') }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ $reservation->debut->format('H:i') }} - {{ $reservation->fin->format('H:i') }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ $reservation->room->nom }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ Str::limit($reservation->titre, 30) }}
                                          </td>
                                          @if(auth()->user()->isA('admin'))
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                                  {{ $reservation->user->identity }}
                                              </td>
                                          @endif
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                              <div class="flex space-x-2">
                                                  <a href="{{ route('reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-800">
                                                      <i class="fas fa-eye">Details</i>
                                                  </a>
                                                  <a href="{{ route('reservations.edit', $reservation) }}" class="text-blue-500 hover:text-blue-700">
                                                      <i class="fas fa-edit">Modifier</i>
                                                  </a>
                                                  <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?');">
                                                      @csrf
                                                      <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                          <i class="fas fa-times-circle">Supprimer</i>
                                                      </button>
                                                  </form>
                                              </div>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @endif
              </div>
          </div>

          <!-- Réservations passées -->
          <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-blue-50 border-b border-blue-200">
                  <h3 class="text-lg font-semibold text-blue-800 mb-4">Réservations passées ou annulées</h3>

                  @if($past->isEmpty())
                      <p class="text-center text-blue-500">{{ __('Aucune réservation passée ou annulée.') }}</p>
                  @else
                      <div class="overflow-x-auto">
                          <table class="min-w-full divide-y divide-blue-200">
                              <thead class="bg-blue-100">
                                  <tr>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Date</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Horaire</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Salle</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Objet</th>
                                      @if(auth()->user()->isA('admin'))
                                          <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Réservé par</th>
                                      @endif
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Statut</th>
                                      <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">Actions</th>
                                  </tr>
                              </thead>
                              <tbody class="bg-blue-50 divide-y divide-blue-200">
                                  @foreach($past as $reservation)
                                      <tr>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-900">
                                              {{ $reservation->debut->format('d/m/Y') }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ $reservation->debut->format('H:i') }} - {{ $reservation->fin->format('H:i') }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ $reservation->room->nom }}
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                              {{ Str::limit($reservation->titre, 30) }}
                                          </td>
                                          @if(auth()->user()->isA('admin'))
                                              <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                                  {{ $reservation->user->identity }}
                                              </td>
                                          @endif
                                          <td class="px-6 py-4 whitespace-nowrap">
                                              @if($reservation->is_cancelled)
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                      Annulée
                                                  </span>
                                              @else
                                                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                      Terminée
                                                  </span>
                                              @endif
                                          </td>
                                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                              <a href="{{ route('reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-800">
                                                  <i class="fas fa-eye">Details</i>
                                              </a>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  @endif
              </div>
          </div>

          <!-- Statistiques -->
          @if(auth()->user()->isA('admin'))
              <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                  <div class="p-6 bg-blue-50 border-b border-blue-200">
                      <h3 class="text-lg font-semibold text-blue-800 mb-4">Statistiques de Réservations</h3>
                      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                          <!-- Total -->
                          <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                              <h4 class="text-blue-800 text-sm font-medium">Total des réservations</h4>
                              <p class="text-xl font-semibold">{{ $totalReservations }}</p>
                          </div>

                          <!-- Annulées -->
                          <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                              <h4 class="text-blue-800 text-sm font-medium">Réservations annulées</h4>
                              <p class="text-xl font-semibold">{{ $totalCancelledReservations }}</p>
                          </div>

                          <!-- Par salle -->
                          <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                              <h4 class="text-blue-800 text-sm font-medium">Réservations par salle</h4>
                              <ul class="list-disc pl-5 text-blue-700">
                                  @foreach($reservationsByRoom as $room)
                                      <li class="text-sm">{{ $room->nom }}: {{ $room->totalReservations }} réservations</li>
                                  @endforeach
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          @endif
      </div>
  </div>
</x-app-layout>
