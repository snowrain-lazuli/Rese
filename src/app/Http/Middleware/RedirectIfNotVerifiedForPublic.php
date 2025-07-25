<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotVerifiedForPublic
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            Auth::logout();
            
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}