<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherProfile;
use App\Models\StudentPreference;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Load preferensi tersimpan dari DB sebagai default
        $savedPref = StudentPreference::where('user_id', auth()->id())->first();

        // Filter aktif: prioritaskan input manual, fallback ke preferensi tersimpan
        $subject      = $request->subject      ?? $savedPref?->subject;
        $jenjang      = $request->jenjang      ?? $savedPref?->jenjang;
        $max_price    = $request->max_price    ?? $savedPref?->max_price;
        $gender       = $request->gender       ?? $savedPref?->gender;
        $availability = $request->availability ?? $savedPref?->availability;

        // Ambil semua guru approved
        $teachers = TeacherProfile::where('status', 'approved')->with('user')->get();

        // Scoring engine: hitung skor kecocokan tiap guru
        $teachers = $teachers->map(function ($teacher) use ($subject, $jenjang, $max_price, $gender, $availability) {
            $score = 0;

            // ── CONTENT-BASED ──────────────────────────────────────────
            // Subject match (bobot tertinggi karena paling relevan)
            if ($subject && str_contains(strtolower($teacher->subject), strtolower($subject))) {
                $score += 40;
            }

            // Jenjang match
            if ($jenjang && strtolower($teacher->jenjang) === strtolower($jenjang)) {
                $score += 25;
            }

            // Price match (dalam budget)
            if ($max_price && $teacher->price <= $max_price) {
                $score += 20;
                // Tambahan skor proporsional jika harga di bawah batas maksimal
                $score += round((($max_price - $teacher->price) / $max_price) * 10);
            }

            // ── RULE-BASED ──────────────────────────────────────────────
            // Rule 1: Gender preference
            if ($gender && $teacher->gender === $gender) {
                $score += 10;
            }

            // Rule 2: Availability match
            if ($availability && str_contains(strtolower($teacher->availability), strtolower($availability))) {
                $score += 15;
            }

            // Rule 3: Tambahan skor jika subject dan jenjang sesuai secara bersamaan
            if (
                $subject && $jenjang &&
                str_contains(strtolower($teacher->subject), strtolower($subject)) &&
                strtolower($teacher->jenjang) === strtolower($jenjang)
            ) {
                $score += 20; // poin tambahan
            }

            // Rule 4: Tambahan skor berdasarkan pengalaman mengajar (maksimal +10)
            if ($teacher->experience) {
                $expYears = (int) filter_var($teacher->experience, FILTER_SANITIZE_NUMBER_INT);
                $score += min($expYears * 2, 10);
            }

            $teacher->score = $score;
            return $teacher;
        });

        // Urutkan by skor tertinggi, kalau sama urutkan by experience
        $teachers = $teachers->sortByDesc('score')->values();

        // Kalau gak ada filter sama sekali (siswa baru, belum ada preferensi)
        // tetap tampilkan semua guru tapi urut by experience
        $hasFilter = $subject || $jenjang || $max_price || $gender || $availability;

        // Kirim preference ke view agar dashboard tidak error
        $preference = $savedPref;

        return view('dashboard', compact(
            'teachers',
            'preference',
            'savedPref',
            'subject',
            'jenjang',
            'max_price',
            'gender',
            'availability',
            'hasFilter'
        ));
    }
}
