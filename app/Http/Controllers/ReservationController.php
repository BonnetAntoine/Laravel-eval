<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Notifications\ReservationCancelled;
use App\Notifications\ReservationConfirmation;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Si l'utilisateur est admin, afficher toutes les réservations
        if (Auth::user()->isA('admin')) {
            // Récupérer les réservations futures
            $upcoming = Reservation::with(['user', 'room'])
                ->where('debut', '>=', now())
                ->where('is_cancelled', false)
                ->orderBy('debut')
                ->get();

            // Récupérer les réservations passées
            $past = Reservation::with(['user', 'room'])
                ->where('debut', '<', now())
                ->orWhere('is_cancelled', true)
                ->orderBy('debut', 'desc')
                ->get();

            // Récupérer le nombre total de réservations (annulées et non annulées)
            $totalReservations = Reservation::count();

            // Récupérer le nombre total de réservations annulées
            $totalCancelledReservations = Reservation::where('is_cancelled', true)->count();

            // Récupérer les réservations par salle
            $reservationsByRoom = Reservation::selectRaw('room_id, COUNT(*) as totalReservations')
                ->where('is_cancelled', false)
                ->groupBy('room_id')
                ->get();

            return view('reservations.index', compact(
                'upcoming',
                'past',
                'totalReservations',
                'totalCancelledReservations',
                'reservationsByRoom'
            ));
        }
        // Sinon, afficher seulement les réservations de l'utilisateur
        $upcoming = Auth::user()->reservations()
            ->with('room')
            ->where('debut', '>=', now())
            ->where('is_cancelled', false)
            ->orderBy('debut')
            ->get();

        $past = Auth::user()->reservations()
            ->with('room')
            ->where('debut', '<', now())
            ->orWhere('is_cancelled', true)
            ->orderBy('debut', 'desc')
            ->get();

        return view('reservations.index', compact('upcoming', 'past'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    /**
     * Summary of create
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $rooms = Room::all();
        $roomId = $request->input('room_id');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        return view('reservations.create', compact('rooms', 'roomId', 'date'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valider d'abord les champs séparés
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'reservation_date' => 'required|date_format:Y-m-d',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:debut',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Recomposer début et fin au format complet Y-m-d H:i
        $debut = Carbon::createFromFormat('Y-m-d H:i', $request->reservation_date . ' ' . $request->debut);
        $fin = Carbon::createFromFormat('Y-m-d H:i', $request->reservation_date . ' ' . $request->fin);

        // Refaire la vérification complète
        if ($fin->lte($debut)) {
            return back()->withInput()->withErrors([
                'fin' => 'L\'heure de fin doit être après l\'heure de début.',
            ]);
        }

        // Vérifier si la salle est déjà réservée
        $conflictingReservation = Reservation::where('room_id', $request->room_id)
            ->where('is_cancelled', false)
            ->where(function ($query) use ($debut, $fin) {
                $query->whereBetween('debut', [$debut, $fin])
                    ->orWhereBetween('fin', [$debut, $fin])
                    ->orWhere(function ($query) use ($debut, $fin) {
                        $query->where('debut', '<=', $debut)
                            ->where('fin', '>=', $fin);
                    });
            })->first();

        if ($conflictingReservation) {
            return back()->withInput()->withErrors([
                'debut' => 'La salle est déjà réservée pendant cette plage horaire.',
            ]);
        }

        // Créer la réservation
        $reservation = new Reservation();
        $reservation->room_id = $request->room_id;
        $reservation->user_id = Auth::id();
        $reservation->debut = $debut;
        $reservation->fin = $fin;
        $reservation->titre = $request->titre;
        $reservation->description = $request->description;
        $reservation->save();

        // Notification de confirmation
        // Auth::user()->notify(new ReservationConfirmation($reservation));

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Display the specified reservation.
     */
    /**
     * Summary of show
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Reservation $reservation)
    {
        // Vérifier si l'utilisateur a le droit de voir cette réservation
        if (! Auth::user()->isA('admin') && Auth::id() !== $reservation->user_id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous n\'avez pas le droit de consulter cette réservation.');
        }

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    /**
     * Summary of edit
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Reservation $reservation)
    {
        // Vérifier si l'utilisateur a le droit de modifier cette réservation
        if (! Auth::user()->isA('admin') && Auth::id() !== $reservation->user_id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous n\'avez pas le droit de modifier cette réservation.');
        }

        // Vérifier si la réservation est dans le futur
        if ($reservation->debut < now()) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous ne pouvez pas modifier une réservation passée.');
        }

        $rooms = Room::all();

        return view('reservations.edit', compact('reservation', 'rooms'));
    }

    /**
     * Update the specified reservation in storage.
     */
    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Vérifier si l'utilisateur a le droit de modifier cette réservation
        if (! Auth::user()->isA('admin') && Auth::id() !== $reservation->user_id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous n\'avez pas le droit de modifier cette réservation.');
        }

        // Vérifier si la réservation est dans le futur
        if ($reservation->debut < now()) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous ne pouvez pas modifier une réservation passée.');
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:debut',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Vérifier si la salle est disponible pour cette plage horaire
        $conflictingReservation = Reservation::where('room_id', $validated['room_id'])
            ->where('id', '!=', $reservation->id)
            ->where('is_cancelled', false)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('debut', [$validated['debut'], $validated['fin']])
                    ->orWhereBetween('fin', [$validated['debut'], $validated['fin']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('debut', '<=', $validated['debut'])
                            ->where('fin', '>=', $validated['fin']);
                    });
            })->first();

        if ($conflictingReservation) {
            return back()->withInput()->withErrors([
                'debut' => 'La salle est déjà réservée pendant cette plage horaire.',
            ]);
        }

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Cancel the specified reservation.
     */
    /**
     * Summary of cancel
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Reservation $reservation)
    {
        // Vérifier si l'utilisateur a le droit d'annuler cette réservation
        if (! Auth::user()->isA('admin') && Auth::id() !== $reservation->user_id) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous n\'avez pas le droit d\'annuler cette réservation.');
        }

        // Vérifier si la réservation est dans le futur
        if ($reservation->debut < now()) {
            return redirect()->route('reservations.index')
                ->with('error', 'Vous ne pouvez pas annuler une réservation passée.');
        }

        $reservation->is_cancelled = true;
        $reservation->save();

        // Envoyer une notification d'annulation
        // $reservation->user->notify(new ReservationCancelled($reservation));

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Check room availability
     */
    /**
     * Summary of checkAvailability
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request)
    {
        $roomId = $request->input('room_id');
        $date = $request->input('date');

        if (! $roomId || ! $date) {
            return response()->json(['error' => 'Paramètres manquants'], 400);
        }

        $room = Room::findOrFail($roomId);

        $reservations = Reservation::with('user')
            ->where('room_id', $roomId)
            ->whereDate('debut', $date)
            ->where('is_cancelled', false)
            ->orderBy('debut')
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'start' => $reservation->debut->toIso8601String(), // format ISO 8601
                    'end' => $reservation->fin->toIso8601String(),     // format ISO 8601
                    'titre' => $reservation->titre,
                    'user' => $reservation->user->name ?? 'Inconnu',
                ];
            });

        return response()->json([
            'room' => $room,
            'reservations' => $reservations,
        ]);
    }
    /**
     * Summary of byRoom
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function byRoom()
    {
        // Vérifie que l'utilisateur est un admin
        if (! Auth::user()->isA('admin')) {
            return redirect()->route('reservations.index')
                ->with('error', 'Accès non autorisé.');
        }

        // Récupère toutes les réservations et les regroupe par salle
        $reservationsByRoom = Reservation::with('room')
            ->where('is_cancelled', false)
            ->orderBy('room_id') // Assure-toi que les réservations sont triées par salle
            ->get()
            ->groupBy('room_id');

        // Préparer les données pour le graphique : compte des réservations par salle et par jour de la semaine
        $weekDays = [];  // Jour de la semaine (par exemple "Monday")
        $bookingCountsByRoom = []; // Nombre de réservations par salle

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $weekDays[] = $date->format('l'); // Jour de la semaine, ex: "Monday"

            foreach ($reservationsByRoom as $roomId => $reservations) {
                $bookingCountsByRoom[$roomId][] = $reservations->filter(function ($reservation) use ($date) {
                    return $reservation->debut->isSameDay($date);
                })->count();
            }
        }

        // Passer les données au graphique
        return view('reservations.by-room', compact('reservationsByRoom', 'weekDays', 'bookingCountsByRoom'));
    }
}
