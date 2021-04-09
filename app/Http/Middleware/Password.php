<?php

namespace App\Http\Middleware;

use Closure, Str, Hash;

use App\User;

class Password
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $scope)
    {
        $users  = User::where('scopes', 'like', '%'.$scope.'%')->get();

        foreach ($users as $user) {
            if(Hash::check(request()->password, $user->password)){
                request()->merge(['spv' => $user->toArray()]);
                return $next($request);
            }
        }

        abort(403);
    }
}
