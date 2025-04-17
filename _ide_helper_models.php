<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Commun{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property int|null $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read string $actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\Commun\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereAssignedTo($model, ?array<int, mixed> $keys = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models\Planning{
/**
 *
 *
 * @property int $id
 * @property int $tache_id
 * @property int $user_id
 * @property int $duree_tache
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $user_id_creation
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 * @property-read string $actions
 * @property-read \App\Models\Planning\Tache|null $tache
 * @property-read User|null $user
 * @property-read User $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 * @method static \Database\Factories\Planning\ArchiveTacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereDureeTache($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereTacheId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArchiveTache withoutTrashed()
 * @mixin \Eloquent
 */
	class ArchiveTache extends \Eloquent {}
}

namespace App\Models\Planning{
/**
 *
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $user_id_creation
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 * @property-read string $actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Planning\Tache> $tache
 * @property-read int|null $tache_count
 * @property-read \App\Models\User $userCreation
 * @property-read \App\Models\User|null $userModification
 * @property-read \App\Models\User|null $userSuppression
 * @method static \Database\Factories\Planning\LieuFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu withoutTrashed()
 * @mixin \Eloquent
 */
	class Lieu extends \Eloquent {}
}

namespace App\Models\Planning{
/**
 *
 *
 * @property int $id
 * @property int $tache_id
 * @property int $user_id
 * @property string $plannifier_le
 * @property Carbon $created_at
 * @property int $user_id_creation
 * @property Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 * @property int $is_validated
 * @property-read string $actions
 * @property-read \App\Models\Planning\Lieu|null $lieu
 * @property-read \App\Models\Planning\Tache $tache
 * @property-read User $user
 * @property-read User $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 * @method static \Database\Factories\Planning\PlanningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereIsValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning wherePlannifierLe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereTacheId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning withoutTrashed()
 * @mixin \Eloquent
 */
	class Planning extends \Eloquent {}
}

namespace App\Models\Planning{
/**
 *
 *
 * @property int $id
 * @property string $nom
 * @property int $lieu_id
 * @property int $user_id
 * @property string $date_debut
 * @property string $date_fin
 * @property int|null $jour Jour de la semaine : 1 pour lundi, 7 pour dimanche
 * @property int $recurrence
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $user_id_creation
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 * @property-read string $actions
 * @property-read \App\Models\Planning\Lieu $lieu
 * @property-read User $user
 * @property-read User $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 * @method static \Database\Factories\Planning\TacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereLieuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereRecurrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache withoutTrashed()
 * @mixin \Eloquent
 */
	class Tache extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read string $identity
 * @property-read string $initials
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Silber\Bouncer\Database\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

