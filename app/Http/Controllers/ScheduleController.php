<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\TeacherProfile;

class ScheduleController extends Controller
{
    // Form booking jadwal
    public function create($teacherProfileId)
    {
        $teacher = TeacherProfile::with('user')->findOrFail($teacherProfileId);
        return view('schedule.create', compact('teacher'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'teacher_profile_id' => ['required', 'exists:teacher_profiles,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        Schedule::create([
            'user_id' => auth()->id(),
            'teacher_profile_id' => $request->teacher_profile_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat, menunggu konfirmasi guru.');
    }

    // Daftar jadwal siswa
    public function index()
    {
        $schedules = Schedule::where('user_id', auth()->id())
            ->with('teacherProfile.user')
            ->latest()
            ->get();

        return view('schedule.index', compact('schedules'));
    }

    // Daftar jadwal guru (yang masuk ke dia)
    public function guruIndex()
    {
        $profile = TeacherProfile::where('user_id', auth()->id())->first();

        $schedules = [];
        if ($profile) {
            $schedules = Schedule::where('teacher_profile_id', $profile->id)
                ->with('user')
                ->latest()
                ->get();
        }

        return view('schedule.guru', compact('schedules'));
    }

    // Guru konfirmasi jadwal
    public function confirm($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'confirmed']);

        return back()->with('success', 'Jadwal dikonfirmasi.');
    }

    // Guru atau siswa batalkan jadwal
    public function cancel($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'batal']);

        return back()->with('success', 'Jadwal dibatalkan.');
    }

    // Guru tandai selesai
    public function complete($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 'selesai']);

        return back()->with('success', 'Jadwal ditandai selesai.');
    }
}
