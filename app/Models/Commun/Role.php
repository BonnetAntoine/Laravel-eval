<?php

namespace App\Models\Commun;

use App\Traits\LogAction;
use Database\Factories\Commun\RoleFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Silber\Bouncer\Database\Role as BouncerRole;

/**
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property int|null $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Collection<int, \Silber\Bouncer\Database\Ability> $abilities
 * @property-read int|null $abilities_count
 * @property-read string $actions
 * @property-read Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\Commun\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereAssignedTo($model, ?array $keys = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Role extends BouncerRole      // @phpstan-ignore-line
{
    /**
     * @use HasFactory<RoleFactory>
     */
    use HasFactory;

    use LogAction;

    public const ADMIN = 'admin';

    public const SALARIE = 'salarie';

    /**
     * @var list<string>
     */
    protected $appends = [
        'actions',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'scope' => 1,
    ];

    /**
     * @var array<string>
     */
    protected static $foreign_keys = [
        'users',
    ];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }
}
