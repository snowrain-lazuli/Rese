<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RedirectIfPasswordNotChanged
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $initialPassword = 'Password123!';

        $isInitialPassword = Hash::check($initialPassword, $user->password);

        if ($isInitialPassword) {
            if (!$request->routeIs('password.change') && !$request->is('password/change')) {
                return redirect()->route('password.change');
            }
        }

        return $next($request);
    }
}