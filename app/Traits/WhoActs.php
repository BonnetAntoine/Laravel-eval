<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Permet de connaître les derniers User ayant agit sur un Model
 *
 * @method userCreation() userCreation(): BelongsTo<User, $this>
 * @method userModification() userModification(): BelongsTo<User, $this>
 * @method userSuppression() userSuppression(): BelongsTo<User, $this>
 */
trait WhoActs
{
    /**
     * Renvoie le User de création du Model
     *
     * @return BelongsTo<User, $this>
     */
    public function userCreation()
    {
        return $this->belongsTo(User::class, 'user_id_creation');
    }

    /**
     * Renvoie le User de modification du Model
     *
     * @return BelongsTo<User, $this>
     */
    public function userModification()
    {
        return $this->belongsTo(User::class, 'user_id_modification');   // @phpstan-ignore-line
    }

    /**
     * Renvoie le User de suppression du Model
     *
     * @return BelongsTo<User, $this>
     */
    public function userSuppression()
    {
        return $this->belongsTo(User::class, 'user_id_suppression');    // @phpstan-ignore-line
    }
}
