<?php

namespace App\Http\Controllers;

use Bouncer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Summary of can
     *
     * @param  string  $ability
     *
     * @return bool
     */
    public function can(string $ability)
    {
        return Bouncer::can($ability);
    }

    /**
     * Summary of isA
     *
     * @param  string  $role
     *
     * @return bool
     */
    public function isA(string $role)
    {
        $user = Auth::user();

        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            return Bouncer::is($user)->a($role);
        }

        return false;
    }
}
