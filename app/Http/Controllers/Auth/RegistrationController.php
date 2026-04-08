<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('pages.auth.signup');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:guru,siswa'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user tapi belum verified
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'phone_verified' => false,
        ]);

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP ke WA
        $fonnte = app(FonnteService::class);
        $fonnte->send($user->phone, "Kode OTP RekoBimbel kamu: {$otp}\nBerlaku 5 menit. Jangan bagikan ke siapapun.");

        // Login dulu tapi belum verified
        Auth::login($user);

        return redirect()->route('otp.verify');
    }
}
