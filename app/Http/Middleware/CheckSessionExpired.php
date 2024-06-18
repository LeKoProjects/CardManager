<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = $request->session()->get('last_activity', time());

            if (time() - $lastActivity > config('session.lifetime') * 60) {
                Auth::logout();
                return redirect()->route('error.419');
            }

            $request->session()->put('last_activity', time());
        }

        return $next($request);
    }
}