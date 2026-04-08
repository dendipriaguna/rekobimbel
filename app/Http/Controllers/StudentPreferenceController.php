<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentPreference;

class StudentPreferenceController extends Controller
{
    // Form isi preferensi
    public function create()
    {
        return view('student.preferences');
    }

    // Simpan preferensi
    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['nullable', 'string', 'max:100'],
            'jenjang' => ['nullable', 'string', 'max:50'],
            'max_price' => ['nullable', 'integer', 'min:0'],
            'gender' => ['nullable', 'in:laki-laki,perempuan'],
            'availability' => ['nullable', 'array'],
            'availability.*' => ['string'],
        ]);

        // Upsert — jika sudah ada update, jika belum buat baru
        StudentPreference::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'subject' => $request->subject,
                'jenjang' => $request->jenjang,
                'max_price' => $request->max_price,
                'gender' => $request->gender,
                'availability' => implode(', ', $request->availability ?? []),
            ]
        );

        return redirect()->route('dashboard')
            ->with('success', 'Preferensi berhasil disimpan!');
    }

    // Edit preferensi (dari dashboard
    public function edit()
    {
        $preference = StudentPreference::where('user_id', auth()->id())->first();
        return view('student.preferences', compact('preference'));
    }

    // Update preferensi
    public function update(Request $request)
    {
        $request->validate([
            'subject' => ['nullable', 'string', 'max:100'],
            'jenjang' => ['nullable', 'string', 'max:50'],
            'max_price' => ['nullable', 'integer', 'min:0'],
            'gender' => ['nullable', 'in:laki-laki,perempuan'],
            'availability' => ['nullable', 'array'],
            'availability.*' => ['string'],
        ]);

        StudentPreference::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'subject' => $request->subject,
                'jenjang' => $request->jenjang,
                'max_price' => $request->max_price,
                'gender' => $request->gender,
                'availability' => implode(', ', $request->availability ?? []),
            ]
        );

        return back()->with('success', 'Preferensi berhasil diperbarui!');
    }
}
