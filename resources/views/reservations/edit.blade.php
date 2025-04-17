<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la réservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                        @csrf
                        @method('PUT')

                        <!-- Sélection de la salle -->
                        <div class="mb-4">
                            <x-input-label for="room_id" :value="__('Salle')" />
                            <select id="room_id" name="room_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Sélectionner une salle</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->nom }} (Capacité: {{ $room->capacite }} personnes)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <!-- Date -->
                        <div class="mb-4">
                          <x-input-label for="reservation_date" :value="__('Date')" />
                          <x-text-input id="reservation_date" class="block mt-1 w-full" type="date" name="reservation_date" :value="old('reservation_date', $reservation->debut->format('Y-m-d'))" required />
                          <x-input-error :messages="$errors->get('reservation_date')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                          <!-- Heure de début -->
                          <div>
                              <x-input-label for="debut" :value="__('Heure de début')" />
                              <x-text-input id="debut" class="block mt-1 w-full" type="time" name="debut" :value="old('debut', $reservation->debut->format('H:i'))" required />
                              <x-input-error :messages="$errors->get('debut')" class="mt-2" />
                          </div>

                          <!-- Heure de fin -->
                          <div>
                              <x-input-label for="fin" :value="__('Heure de fin')" />
                              <x-text-input id="fin" class="block mt-1 w-full" type="time" name="fin" :value="old('fin', $reservation->fin->format('H:i'))" required />
                              <x-input-error :messages="$errors->get('fin')" class="mt-2" />
                          </div>
                        </div>


                        <!-- Objet de la réservation -->
                        <div class="mb-4">
                            <x-input-label for="titre" :value="__('Objet de la réservation')" />
                            <x-text-input id="titre" class="block mt-1 w-full" type="text" name="titre" :value="old('titre', $reservation->titre)" required />
                            <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description (optionnelle)')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('description', $reservation->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Zone d'affichage des disponibilités -->
                        <div id="availability-container" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                            <h3 class="text-md font-semibold text-gray-700 mb-2">Disponibilité de la salle</h3>
                            <div id="availability-loading" class="text-center py-4 hidden">
                                <i class="fas fa-spinner fa-spin"></i> Chargement des disponibilités...
                            </div>
                            <div id="availability-content"></div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_id');
            const dateInput = document.getElementById('reservation_date');
            const startTimeInput = document.getElementById('debut');
            const endTimeInput = document.getElementById('fin');
            const availabilityContainer = document.getElementById('availability-container');
            const availabilityLoading = document.getElementById('availability-loading');
            const availabilityContent = document.getElementById('availability-content');

            // ID de la réservation actuelle
            const currentReservationId = {{ $reservation->id }};

            // Fonction pour formater la date et l'heure pour l'envoi à l'API
            function formatDateTime(date, time) {
                return `${date}T${time}`;
            }

            // Fonction pour vérifier les disponibilités
            function checkAvailability() {
                const roomId = roomSelect.value;
                const date = dateInput.value;

                if (!roomId || !date) {
                    availabilityContainer.classList.add('hidden');
                    return;
                }

                availabilityContainer.classList.remove('hidden');
                availabilityLoading.classList.remove('hidden');
                availabilityContent.innerHTML = '';

                fetch(`{{ route('reservations.check-availability') }}?room_id=${roomId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        availabilityLoading.classList.add('hidden');

                        // Filtrer les réservations pour exclure celle en cours d'édition
                        const filteredReservations = data.reservations.filter(res => res.id != currentReservationId);

                        if (filteredReservations.length === 0) {
                            availabilityContent.innerHTML = '<p class="text-green-600"><i class="fas fa-check-circle mr-2"></i> La salle est disponible toute la journée.</p>';
                            return;
                        }

                        let html = '<p class="mb-2">Réservations existantes pour cette date:</p>';
                        html += '<ul class="space-y-1">';

                        filteredReservations.forEach(reservation => {
                            const startTime = new Date(reservation.start);
                            const endTime = new Date(reservation.end);

                            html += `<li class="flex items-center text-sm">
                                <span class="inline-block w-20 font-medium">${startTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })} - ${endTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}</span>
                                <span class="ml-2">${reservation.title} (${reservation.user})</span>
                            </li>`;
                        });

                        html += '</ul>';
                        html += '<p class="mt-3 text-sm text-gray-600">Veuillez choisir un créneau horaire disponible.</p>';

                        availabilityContent.innerHTML = html;
                    })
                    .catch(error => {
                        availabilityLoading.classList.add('hidden');
                        availabilityContent.innerHTML = '<p class="text-red-600">Erreur lors de la vérification des disponibilités.</p>';
                        console.error('Erreur:', error);
                    });
            }

            // Events listeners
            roomSelect.addEventListener('change', checkAvailability);
            dateInput.addEventListener('change', checkAvailability);

            // Traitement du formulaire pour combiner date et heure
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();

                const date = dateInput.value;
                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;

                if (!date || !startTime || !endTime) {
                    return true; // Laisser la validation HTML5 gérer cela
                }

                // Création des champs cachés pour transmettre les valeurs au format correct
                const startTimeField = document.createElement('input');
                startTimeField.type = 'hidden';
                startTimeField.name = 'start_time';
                startTimeField.value = formatDateTime(date, startTime);

                const endTimeField = document.createElement('input');
                endTimeField.type = 'hidden';
                endTimeField.name = 'end_time';
                endTimeField.value = formatDateTime(date, endTime);

                // Supprimer le champ date pour éviter la confusion
                dateInput.name = '';
                startTimeInput.name = '';
                endTimeInput.name = '';

                this.appendChild(startTimeField);
                this.appendChild(endTimeField);

                this.submit();
            });

            // Vérifier les disponibilités au chargement
            checkAvailability();
        });
    </script>
    @endpush
</x-app-layout>
