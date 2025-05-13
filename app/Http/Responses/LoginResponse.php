<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Log;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();
        
        // Log role user untuk debugging
        Log::info('User login: ' . $user->email . ' dengan role: ' . $user->role);
        
        // Redirect admin ke dashboard admin (pastikan persis 'admin', case-sensitive)
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        // Redirect event organizer ke dashboard organizer
        if ($user->role === 'eo') {
            return redirect()->intended(route('organizer.dashboard'));
        }
        
        // Default untuk semua user lainnya (user biasa)
        return redirect()->intended(route('dashboard'));
    }
} 