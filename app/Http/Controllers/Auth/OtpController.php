<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FonnteService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    // Halaman input OTP
    public function show()
    {
        // Jika sudah terverifikasi, langsung alihkan ke dashboard
        if (auth()->user()->phone_verified) {
            return redirect()->route('dashboard');
        }

        return view('pages.auth.verify-otp');
    }

    // Verifikasi kode OTP
    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $user = auth()->user();

        // Cek OTP expired
        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP sudah expired. Silakan kirim ulang.');
        }

        // Cek OTP cocok
        if ($user->otp_code !== $request->otp_code) {
            return back()->with('error', 'Kode OTP salah.');
        }

        // Verified
        $user->update([
            'phone_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Nomor WhatsApp berhasil diverifikasi!');
    }

    // Kirim ulang OTP
    public function resend()
    {
        $user = auth()->user();

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $fonnte = app(FonnteService::class);
        $fonnte->send($user->phone, "Kode OTP RekoBimbel kamu: {$otp}\nBerlaku 5 menit. Jangan bagikan ke siapapun.");

        return back()->with('success', 'OTP baru sudah dikirim ke WhatsApp kamu.');
    }
    public function changePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:20', \Illuminate\Validation\Rule::unique('users')->ignore(auth()->id())],
        ]);

        $user = auth()->user();
        $user->phone = $request->phone;

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        $fonnte = app(FonnteService::class);
        $fonnte->send($user->phone, "Kode OTP RekoBimbel untuk nomor baru kamu: {$otp}\nBerlaku 5 menit.");

        return back()->with('success', 'Nomor berhasil diubah. Kode OTP baru telah dikirim ke nomor tersebut.');
    }
}
