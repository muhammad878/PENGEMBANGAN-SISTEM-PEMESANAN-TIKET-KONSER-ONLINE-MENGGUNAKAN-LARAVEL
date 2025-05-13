<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        Log::info("RedirectBasedOnRole: Current path: '{$path}'");
        
        // Proses request normally jika sudah di path yang sesuai
        if ($request->is('admin/*') || $request->is('organizer/*') || $request->is('dashboard')) {
            Log::info("RedirectBasedOnRole: Already in correct path, proceeding normally");
            return $next($request);
        }
        
        // Redirect berdasarkan role
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log untuk debugging
            Log::info("RedirectBasedOnRole: User authenticated - {$user->email} with role: '{$user->role}'");
            
            if ($user->role === 'admin') {
                Log::info("RedirectBasedOnRole: Redirecting admin to admin.dashboard");
                return redirect()->route('admin.dashboard');
            } else if ($user->role === 'eo') {
                Log::info("RedirectBasedOnRole: Redirecting EO to organizer.dashboard");
                return redirect()->route('organizer.dashboard');
            } else {
                Log::info("RedirectBasedOnRole: Redirecting regular user to dashboard");
                return redirect()->route('dashboard');
            }
        } else {
            Log::info("RedirectBasedOnRole: User not authenticated, proceeding normally");
        }
        
        return $next($request);
    }
} 