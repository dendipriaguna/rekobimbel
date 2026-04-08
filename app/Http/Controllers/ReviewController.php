<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Schedule;

class ReviewController extends Controller
{
    // Simpan review dari siswa -- hanya bisa jika memiliki jadwal selesai dengan guru ini
    public function store(Request $request)
    {
        $request->validate([
            'teacher_profile_id' => ['required', 'exists:teacher_profiles,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'ulasan' => ['nullable', 'string', 'max:500'],
        ]);

        // Cek apakah siswa punya jadwal selesai dengan guru ini
        $punyaJadwalSelesai = Schedule::where('user_id', auth()->id())
            ->where('teacher_profile_id', $request->teacher_profile_id)
            ->where('status', 'selesai')
            ->exists();

        if (!$punyaJadwalSelesai) {
            return back()->with('error', 'Kamu hanya bisa mereview setelah jadwal belajar selesai.');
        }

        // Cek supaya ga double review
        $exists = Review::where('user_id', auth()->id())
            ->where('teacher_profile_id', $request->teacher_profile_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kamu sudah pernah mereview guru ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'teacher_profile_id' => $request->teacher_profile_id,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return back()->with('success', 'Review berhasil dikirim.');
    }
}
