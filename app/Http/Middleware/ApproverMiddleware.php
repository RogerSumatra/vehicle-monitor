<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApproverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah user login dan memiliki role approver
        if (Auth::check() && Auth::user()->role === 'approver') {
            return $next($request);
        }

        // Redirect jika tidak memiliki akses
        return redirect('/dashboard')->with('error', 'Akses ditolak.');
    }
}
