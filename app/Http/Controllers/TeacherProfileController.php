<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherProfile;
use Illuminate\Support\Facades\Auth;

class TeacherProfileController extends Controller
{
    // Form isi profil baru
    public function create()
    {
        return view('guru.profile');
    }

    // Simpan profil baru
    public function store(Request $request)
    {
        TeacherProfile::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'experience' => $years . ' tahun ' . $months . ' bulan',
            'education' => $request->education,
            'price' => $request->price,
            'availability' => implode(', ', $request->availability ?? []),
            'gender' => $request->gender,
            'jenjang' => $request->jenjang,
            'detail' => $request->detail,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil disimpan, menunggu persetujuan admin.');
    }

    // Form edit profil
    public function edit()
    {
        $profile = TeacherProfile::where('user_id', Auth::id())->first();
        return view('guru.profile', compact('profile'));
    }

    // Update profil
    public function update(Request $request)
    {
        $profile = TeacherProfile::where('user_id', Auth::id())->first();
        $years = $request->input('experience_years', 0);
        $months = $request->input('experience_months', 0);

        $profile->update([
            'subject' => $request->subject,
            'experience' => $years . ' tahun ' . $months . ' bulan',
            'education' => $request->education,
            'price' => $request->price,
            'availability' => implode(', ', $request->availability ?? []),
            'gender' => $request->gender,
            'jenjang' => $request->jenjang,
            'detail' => $request->detail,
            'status' => 'pending' // reset ke pending setelah edit
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil diperbarui, menunggu persetujuan ulang admin.');
    }

    // Guru lihat review yang masuk
    public function reviews()
    {
        $profile = TeacherProfile::where('user_id', Auth::id())->first();

        $reviews = collect();
        if ($profile) {
            $reviews = $profile->reviews()->with('user')->latest()->get();
        }

        return view('guru.reviews', compact('reviews'));
    }
}