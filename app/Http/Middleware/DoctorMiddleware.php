<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Kiểm tra: Nếu role = 2 (Doctor)
    if (Auth::check() && Auth::user()->role === 'doctor') {
        return $next($request);
    }
    return redirect('/')->with('error', 'Bạn không phải là bác sĩ!');
}
}
