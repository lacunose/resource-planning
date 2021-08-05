<?php

namespace App\Http\Middleware;

use Closure, Str;
use Illuminate\Support\Facades\Auth;

class Endpoint {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check() && Auth::user()->endpoints) {

            $eps    = Auth::user()->endpoints;
            $rl     = config()->get('tacl.opsi.role');

            foreach ($rl as $p => $r) {
                $ep = $eps->filter(function ($item) use ($p) {
                        return false !== in_array($p, $item['roles']);
                    })->toarray();
                $cnf    = [];

                $ff     = request()->get('filter');
                $f      = explode('.', $p);

                foreach ($ep as $e) {
                    $cnf[$e['name']] = $e['name'];
                    // config()->set($f[0].'.yellowbook.'.$e['name'], $e);
                }

                if(!isset($ff[$f[2]]) || !array_intersect($ff[$f[2]], $cnf) && count($cnf)) {
                    $ff[$f[2]]  = $cnf;
                }
                
                //set pfn
                config()->set($p, $cnf);
                request()->merge(['filter' => $ff]);
            }

            $dms    = config()->get('tsub.support');
            foreach ($dms as $dm) {
                config()->set($dm.'.yellowbook', session()->get($dm.'.yellowbook'));
            }
        }

        return $next($request);
    }
}
