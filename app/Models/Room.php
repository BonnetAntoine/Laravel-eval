<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nom
 * @property int $capacite
 * @property float|null $surface Surface en m²
 * @property string|null $equipment Équipements disponibles
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereCapacite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereEquipment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Room withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Room extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs qui sont mass assignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'capacite',
        'surface',
        'equipment',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacite' => 'integer',
        'surface' => 'float',
    ];

    /**
     * Obtenir les réservations pour cette salle.
     */
    /**
     * Summary of reservations
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Reservation, Room>
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Vérifier si la salle est disponible pour une plage horaire donnée
     */
    /**
     * Summary of isAvailable
     * @param mixed $debut
     * @param mixed $fin
     * @param mixed $excludeReservationId
     * @return bool
     */
    public function isAvailable($debut, $fin, $excludeReservationId = null)
    {
        $query = $this->reservations()
            ->where('is_cancelled', false)
            ->where(function ($query) use ($debut, $fin) {
                $query->whereBetween('debut', [$debut, $fin])
                    ->orWhereBetween('fin', [$debut, $fin])
                    ->orWhere(function ($query) use ($debut, $fin) {
                        $query->where('debut', '<=', $debut)
                            ->where('fin', '>=', $fin);
                    });
            });

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return ! $query->exists();
    }
}
