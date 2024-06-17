<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAccount
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->account_status == 1) {
            return $next($request);
        }

        return redirect()->route('verification.required');
    }
}