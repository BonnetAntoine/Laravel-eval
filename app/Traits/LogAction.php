<?php

namespace App\Traits;

use App\Models\User;
use Auth;
use Log;
use Session;
use Str;
use Throwable;

/**
 * @codeCoverageIgnore
 */
trait LogAction
{
    /** @return void  */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model::$logCreating ?? false) {
                static::log('creating', $model);            // @phpstan-ignore-line
            }
        });

        static::created(function ($model) {
            if ($model::$logCreated ?? true) {
                static::log('created', $model);             // @phpstan-ignore-line
            }
        });

        static::updating(function ($model) {
            if ($model::$logUpdating ?? false) {
                static::log('updating', $model);            // @phpstan-ignore-line
            }
        });

        static::updated(function ($model) {
            if ($model::$logUpdated ?? true) {
                static::log('updated', $model);             // @phpstan-ignore-line
            }
        });

        static::deleting(function ($model) {
            if (count($model::$foreign_keys ?? []) > 0) {
                foreach ($model::$foreign_keys as $foreign_key) {
                    $count = $model->$foreign_key()->count();
                    if ($count > 0) {
                        Session::put('erreur', __('Deletion impossible because still connected to :count :entities', [
                            'count' => $count,
                            'entities' => $count > 1 ? __(Str::headline($foreign_key)) : __(Str::singular(Str::headline($foreign_key))),
                        ]));

                        return false;
                    }
                }
            }

            if ($model::$logDeleting ?? false) {
                static::log('creating', $model);            // @phpstan-ignore-line
            }
        });

        static::deleted(function ($model) {
            if ($model::$logDeleted ?? true) {
                static::log('deleted', $model);             // @phpstan-ignore-line
            }
        });

        static::retrieved(function ($model) {
            if ($model::$logRetrieved ?? false) {
                static::log('retrieved', $model);           // @phpstan-ignore-line
            }
        });

        static::saving(function ($model) {
            if ($model::$logSaving ?? false) {
                static::log('saving', $model);              // @phpstan-ignore-line
            }
        });

        static::saved(function ($model) {
            if ($model::$logSaved ?? true) {
                static::log('saved', $model);               // @phpstan-ignore-line
            }
        });

        try {
            static::restoring(function ($model) {           // @phpstan-ignore-line
                if ($model::$logRestoring ?? false) {
                    static::log('restoring', $model);       // @phpstan-ignore-line
                }
            });
        } catch (Throwable) {
        }

        try {
            static::restored(function ($model) {            // @phpstan-ignore-line
                if ($model::$logRestored ?? true) {
                    static::log('restored', $model);        // @phpstan-ignore-line
                }
            });
        } catch (Throwable) {
        }

        static::replicating(function ($model) {
            if ($model::$logReplicating ?? true) {
                static::log('replicating', $model);         // @phpstan-ignore-line
            }
        });
    }

    /**
     * @param  string  $action
     * @param  mixed  $model
     *
     * @return void
     */
    private static function log(string $action, $model)
    {
        Log::info($action . ' model ' . static::class);
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            Log::info($user->identity);
        } else {
            Log::info('Non connecté / Anonyme');
        }
        Log::info($model);
        $custom = 'custom' . ucfirst($action);
        if (method_exists($model, $custom)) {
            $model::$custom($model);         // @phpstan-ignore-line
        }
    }
}
