<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('pages.auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = \App\Models\User::where('phone', $request->phone)->first();

        if ($user) {
            // Generate standard password reset token
            $token = Password::broker()->createToken($user);
            
            // Build the standard reset URL expected by NewPasswordController
            $url = route('password.reset', ['token' => $token, 'email' => $user->email]);
            
            // Send via Fonnte
            $fonnte = app(\App\Services\FonnteService::class);
            $fonnte->send($user->phone, "Klik link berikut untuk mereset password RekoBimbel anda:\n\n{$url}\n\nJika anda tidak meminta reset password, abaikan pesan ini.");
        }

        return back()->with('status', 'Jika nomor WhatsApp terdaftar, link reset telah dikirim.');
    }
}

