<?php

namespace App\Classes\Commun;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;

/**
 * @codeCoverageIgnore
 */
class ExtendBlueprint extends Blueprint
{
    /**
     * Création des colones pour horodater l'action et connaître le dernier user ayant opéré
     *
     * @param  bool  $useSoftDeletes  Indique si la suppression logique est activée, true par défaut
     *
     * @return void
     */
    public function whoAndWhen(bool $useSoftDeletes = true)
    {
        $this->timestamp('created_at')
            ->useCurrent();
        $this->foreignIdFor(User::class, 'user_id_creation')
            ->constrained();

        $this->timestamp('updated_at')
            ->nullable();
        $this->foreignIdFor(User::class, 'user_id_modification')
            ->nullable()
            ->constrained();

        if ($useSoftDeletes) {
            $this->timestamp('deleted_at')
                ->nullable();
            $this->foreignIdFor(User::class, 'user_id_suppression')
                ->nullable()
                ->constrained();
        }
    }
}
