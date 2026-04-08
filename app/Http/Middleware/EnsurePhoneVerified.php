<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: pastikan user sudah verifikasi OTP sebelum mengakses fitur
class EnsurePhoneVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->phone_verified) {
            return redirect()->route('otp.verify');
        }

        return $next($request);
    }
}
