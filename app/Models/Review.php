<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_profile_id',
        'rating',
        'ulasan',
    ];

    // Siswa yang kasih review
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Guru yang direview
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }
}
