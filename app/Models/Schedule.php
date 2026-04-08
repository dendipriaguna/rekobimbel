<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_profile_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'catatan',
    ];

    // Siswa yang booking
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Guru yang dibooking
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }
}
