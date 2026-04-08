<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'experience',
        'education',
        'price',
        'availability',
        'gender',
        'status',
        'jenjang',
        'detail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Review yang masuk ke guru ini
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Jadwal belajar guru ini
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
