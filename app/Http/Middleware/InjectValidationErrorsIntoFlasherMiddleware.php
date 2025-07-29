<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectValidationErrorsIntoFlasherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ➜ on agit AVANT le contrôleur (les erreurs sont celles
        //    du précédent redirect après échec de validation)
        if ($request->session()->has('errors')) {
            /** @var \Illuminate\Support\MessageBag $bag */
            $bag = $request->session()->get('errors');

            foreach ($bag->all() as $message) {
                // un toast "error" par message
                \Flasher::addError(message: $message,title: 'Erreur');
            }
        }
        return $next($request);
    }
}
