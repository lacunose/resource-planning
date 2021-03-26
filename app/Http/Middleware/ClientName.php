<?php

namespace App\Http\Middleware;

use Closure, Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class ClientName {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //CEK WEB
        if (Auth::check() && !Auth::user()->token() && !in_array(Auth::user()->clients, ['WMM01'])) {
            abort(403);
        }

        //CEK API
        if (Auth::check() && Auth::user()->token() && !in_array(Auth::user()->token()->client->name, Auth::user()->clients)) {
            throw new AuthorizationException('Missing client access: '.Auth::user()->token()->client->name, 403);
        }

        return $next($request);
    }
}
