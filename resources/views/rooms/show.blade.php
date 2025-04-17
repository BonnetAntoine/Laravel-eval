<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-semibold text-gray-800">Information sur la salle</h3>
                                <p class="text-gray-600"><i class="fas fa-users mr-2"></i> Capacité: {{ $room->capacite }} personnes</p>
                                @if($room->surface)
                                    <p class="text-gray-600"><i class="fas fa-vector-square mr-2"></i> Surface: {{ $room->surface }} m²</p>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-calendar-plus mr-2"></i> {{ __('Réserver cette salle') }}
                                </a>
                            </div>
                        </div>

                        @if($room->equipment)
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-700">Équipements:</h4>
                                <p class="text-gray-600">{{ $room->equipment }}</p>
                            </div>
                        @endif
                    </div>

                    <hr class="my-6">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Réservations à venir</h3>

                        <div class="mb-4">
                            <input type="date" id="filter-date" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ date('Y-m-d') }}">
                            <button id="btn-filter" class="ml-2 inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrer
                            </button>
                        </div>

                        <div id="calendar-container">
                            <div id="reservations-list">
                                @if($reservations->isEmpty())
                                    <p class="text-center text-gray-500">Aucune réservation à venir pour cette salle.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horaire</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Objet</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservé par</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($reservations as $reservation)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $reservation->debut->format('d/m/Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $reservation->debut->format('H:i') }} - {{ $reservation->fin->format('H:i') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $reservation->titre }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $reservation->user->nom }} {{ $reservation->user->prenom }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            <a href="{{ route('reservations.show', $reservation) }}" class="text-indigo-600 hover:text-indigo-900">Détails</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handler pour le filtrage par date
            document.getElementById('btn-filter').addEventListener('click', function() {
                const date = document.getElementById('filter-date').value;
                loadReservations(date);
            });

            // Fonction pour charger les réservations par AJAX
            function loadReservations(date) {
                fetch(`{{ route('reservations.check-availability') }}?room_id={{ $room->id }}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('reservations-list');

                        if (data.reservations.length === 0) {
                            container.innerHTML = '<p class="text-center text-gray-500">Aucune réservation pour cette date.</p>';
                            return;
                        }

                        let html = `
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horaire</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Objet</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservé par</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">`;

                        data.reservations.forEach(reservation => {
                            const startTime = new Date(reservation.start);
                            const endTime = new Date(reservation.end);

                            html += `
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${startTime.toLocaleDateString('fr-FR')}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${startTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })} -
                                        ${endTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${reservation.titre}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${reservation.user}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="/reservations/${reservation.id}" class="text-indigo-600 hover:text-indigo-900">Détails</a>
                                    </td>
                                </tr>`;
                        });

                        html += `
                                    </tbody>
                                </table>
                            </div>`;

                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            }
        });
    </script>
    @endpush
</x-app-layout>
