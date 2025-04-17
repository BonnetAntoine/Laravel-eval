<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class WelcomeController extends Controller
{
    /**
     * @return RedirectResponse
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidArgumentException
     */
    public function index()
    {
        /**
         * @var User
         */
        $user = Auth::user();

        if ($user->isA('salarie')) {
            return redirect()->route('planning.index');
        }

        return redirect()->route('synthese.index');
    }
}
