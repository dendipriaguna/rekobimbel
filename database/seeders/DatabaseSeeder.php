<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\Review;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '',
            'password' => bcrypt('ad6281000000001min123'),
            'phone_verified' => true,
        ]);

        // Guru + profil
        $guruData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'subject' => 'Matematika',
                'experience' => '5 tahun',
                'education' => 'S1 Pendidikan Matematika',
                'price' => 75000,
                'availability' => 'Senin, Rabu, Jumat',
                'gender' => 'laki-laki',
                'jenjang' => 'SMA',
                'detail' => 'Berpengalaman mengajar siswa olimpiade matematika',
                'status' => 'approved',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'subject' => 'Bahasa Inggris',
                'experience' => '3 tahun',
                'education' => 'S1 Sastra Inggris',
                'price' => 60000,
                'availability' => 'Selasa, Kamis, Sabtu',
                'gender' => 'perempuan',
                'jenjang' => 'SMP',
                'detail' => 'Fokus pada speaking dan grammar',
                'status' => 'approved',
            ],
            [
                'name' => 'Ahmad Rizky',
                'email' => 'ahmad@gmail.com',
                'subject' => 'Fisika',
                'experience' => '7 tahun',
                'education' => 'S2 Fisika',
                'price' => 100000,
                'availability' => 'Senin, Selasa, Rabu',
                'gender' => 'laki-laki',
                'jenjang' => 'SMA',
                'detail' => 'Spesialis persiapan UTBK dan olimpiade sains',
                'status' => 'approved',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'subject' => 'Matematika',
                'experience' => '2 tahun',
                'education' => 'S1 Matematika',
                'price' => 50000,
                'availability' => 'Sabtu, Minggu',
                'gender' => 'perempuan',
                'jenjang' => 'SD',
                'detail' => 'Sabar mengajar anak-anak, metode fun learning',
                'status' => 'approved',
            ],
            [
                'name' => 'Reza Pratama',
                'email' => 'reza@gmail.com',
                'subject' => 'Kimia',
                'experience' => '4 tahun',
                'education' => 'S1 Kimia',
                'price' => 80000,
                'availability' => 'Senin, Kamis, Sabtu',
                'gender' => 'laki-laki',
                'jenjang' => 'SMA',
                'detail' => 'Mengajar dengan pendekatan eksperimen praktis',
                'status' => 'approved',
            ],
            [
                'name' => 'Nur Haliza',
                'email' => 'haliza@gmail.com',
                'subject' => 'Bahasa Inggris',
                'experience' => '6 tahun',
                'education' => 'S2 Linguistik',
                'price' => 90000,
                'availability' => 'Senin, Rabu, Jumat',
                'gender' => 'perempuan',
                'jenjang' => 'SMA',
                'detail' => 'IELTS preparation dan academic writing',
                'status' => 'approved',
            ],
            [
                'name' => 'Irfan Hakim',
                'email' => 'irfan@gmail.com',
                'subject' => 'Biologi',
                'experience' => '1 tahun',
                'education' => 'S1 Biologi',
                'price' => 45000,
                'availability' => 'Selasa, Kamis',
                'gender' => 'laki-laki',
                'jenjang' => 'SMP',
                'detail' => 'Fresh graduate, semangat mengajar tinggi',
                'status' => 'pending',
            ],
        ];

        $guruUsers = [];
        foreach ($guruData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'role' => 'guru',
                'email' => $data['email'],
                'phone' => '628100000' . str_pad(array_search($data, $guruData) + 2, 4, '0', STR_PAD_LEFT),
                'password' => bcrypt('guru123'),
                'phone_verified' => true,
            ]);

            TeacherProfile::create([
                'user_id' => $user->id,
                'subject' => $data['subject'],
                'experience' => $data['experience'],
                'education' => $data['education'],
                'price' => $data['price'],
                'availability' => $data['availability'],
                'gender' => $data['gender'],
                'jenjang' => $data['jenjang'],
                'detail' => $data['detail'],
                'status' => $data['status'],
            ]);

            $guruUsers[] = $user;
        }

        // Siswa
        $siswaData = [
            ['name' => 'Andi Wijaya', 'email' => 'andi@gmail.com'],
            ['name' => 'Maya Putri', 'email' => 'maya@gmail.com'],
            ['name' => 'Dimas Arya', 'email' => 'dimas@gmail.com'],
        ];

        $siswaUsers = [];
        foreach ($siswaData as $data) {
            $siswaUsers[] = User::create([
                'name' => $data['name'],
                'role' => 'siswa',
                'email' => $data['email'],
                'phone' => '628200000' . str_pad(array_search($data, $siswaData) + 1, 4, '0', STR_PAD_LEFT),
                'password' => bcrypt('siswa123'),
                'phone_verified' => true,
            ]);
        }

        // Review dari siswa ke guru yang approved
        $reviewData = [
            ['siswa' => 0, 'guru' => 0, 'rating' => 5, 'ulasan' => 'Pak Budi ngajarnya enak banget, sabar dan jelas.'],
            ['siswa' => 0, 'guru' => 1, 'rating' => 4, 'ulasan' => 'Bu Siti oke, speaking saya jadi lebih lancar.'],
            ['siswa' => 1, 'guru' => 0, 'rating' => 4, 'ulasan' => 'Penjelasannya mudah dipahami.'],
            ['siswa' => 1, 'guru' => 2, 'rating' => 5, 'ulasan' => 'Pak Ahmad top, materi fisika jadi gampang.'],
            ['siswa' => 2, 'guru' => 3, 'rating' => 5, 'ulasan' => 'Bu Dewi ramah banget sama anak saya.'],
            ['siswa' => 2, 'guru' => 4, 'rating' => 3, 'ulasan' => 'Lumayan, tapi kadang terlalu cepat.'],
        ];

        foreach ($reviewData as $data) {
            $guruProfile = TeacherProfile::where('user_id', $guruUsers[$data['guru']]->id)->first();
            Review::create([
                'user_id' => $siswaUsers[$data['siswa']]->id,
                'teacher_profile_id' => $guruProfile->id,
                'rating' => $data['rating'],
                'ulasan' => $data['ulasan'],
            ]);
        }

        // Jadwal belajar
        $scheduleData = [
            ['siswa' => 0, 'guru' => 0, 'tanggal' => '2025-04-07', 'jam_mulai' => '09:00', 'jam_selesai' => '10:30', 'status' => 'confirmed', 'catatan' => 'Belajar integral'],
            ['siswa' => 0, 'guru' => 1, 'tanggal' => '2025-04-08', 'jam_mulai' => '14:00', 'jam_selesai' => '15:30', 'status' => 'pending', 'catatan' => 'Latihan speaking'],
            ['siswa' => 1, 'guru' => 2, 'tanggal' => '2025-04-07', 'jam_mulai' => '10:00', 'jam_selesai' => '11:30', 'status' => 'confirmed', 'catatan' => 'Materi gerak parabola'],
            ['siswa' => 2, 'guru' => 3, 'tanggal' => '2025-04-12', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'status' => 'selesai', 'catatan' => 'Perkalian dan pembagian'],
            ['siswa' => 1, 'guru' => 0, 'tanggal' => '2025-04-09', 'jam_mulai' => '13:00', 'jam_selesai' => '14:30', 'status' => 'batal', 'catatan' => 'Batal karena sakit'],
        ];

        foreach ($scheduleData as $data) {
            $guruProfile = TeacherProfile::where('user_id', $guruUsers[$data['guru']]->id)->first();
            Schedule::create([
                'user_id' => $siswaUsers[$data['siswa']]->id,
                'teacher_profile_id' => $guruProfile->id,
                'tanggal' => $data['tanggal'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'],
                'status' => $data['status'],
                'catatan' => $data['catatan'],
            ]);
        }
    }
}