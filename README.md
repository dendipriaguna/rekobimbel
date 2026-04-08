# RekoBimbel - Sistem Rekomendasi Penempatan Guru

Aplikasi web untuk mencari dan merekomendasikan guru les privat berdasarkan preferensi siswa secara cerdas dan otomatis.
Dibuat dengan sistem *Mobile-First Design* menggunakan ekosistem Laravel + Blade + Tailwind CSS.

## Fitur Utama

- **Otentikasi & Keamanan:** 
  - Login & Register (Admin, Guru, Siswa).
  - **Verifikasi OTP WhatsApp:** Menggunakan API Fonnte untuk validasi nomor aktif guna mencegah akun fiktif/spam.
- **Manajemen Pengguna:**
  - Dashboard spesifik berdasarkan peran pengguna (Role-based access).
  - Guru dapat mengisi dan memperbarui profil (Mata Pelajaran, Jenjang, Tarif, Ketersediaan Waktu, Pengalaman).
  - Admin melakukan kurasi (*Approve/Reject*) terhadap profil guru yang mendaftar.
- **Rekomendasi Cerdas:**
  - Siswa mengisi preferensi belajar.
  - Sistem menampilkan rekomendasi guru secara otomatis melalui *Scoring Engine*.
- **Booking & Penjadwalan:**
  - Siswa dapat melakukan permohonan (*booking*) jadwal belajar dari daftar rekomendasi.
  - Guru mengelola pesanan masuk (Konfirmasi, Tolak, atau Selesai).
- **Sistem Rating & Ulasan:**
  - Validasi ketat: Siswa hanya dapat memberikan *rating* dan ulasan jika sudah memiliki jadwal dengan status **Selesai**.
  - Guru dapat memantau *feedback* siswa langsung melalui dashboard.

## Akun Default (Seeder)

Silakan gunakan kredensial berikut untuk keperluan testing:

- **Admin:** `admin@gmail.com` / `admin123`
- **Siswa Dummy:** `andi@gmail.com` / `siswa123`
- **Guru Dummy:** `nisa@gmail.com` / `guru123` 

*(Setiap akun di atas sudah otomatis terverifikasi sistem OTP dalam database seeding)*.

## Teknologi

- **Backend:** PHP 8.2+ & Laravel 11/12
- **Frontend / UI:** Tailwind CSS, Alpine.js, Blade Components
- **Database:** MySQL
- **Gateway:** [Fonnte API](https://fonnte.com/) (WhatsApp integration)
- **Base Template:** TailAdmin Starter Kit

## Struktur Kode Utama

```
app/
  Controllers/
    Auth/
        OtpController.php           -> Menangani konfirmasi & resend kode OTP WA
        RegistrationController.php  -> Registrasi + triger kirim OTP perdana
    DashboardController.php         -> Redirect & layouting dashboard per role
    ReviewController.php            -> Sistem input rating dan ulasan (anti double ulasan)
    ScheduleController.php          -> Sistem negosiasi dan booking jadwal
    StudentController.php           -> Scoring engine + interface cari guru
    StudentPreferenceController.php -> Preferensi profil belajar siswa
    TeacherProfileController.php    -> Formulir rekam jejak guru
  Models/
    User, TeacherProfile, StudentPreference, Schedule, Review
  Services/
    FonnteService.php               -> Wrapper HTTP Client untuk hit Fonnte API 
  Middleware/
    EnsurePhoneVerified.php         -> Gatekeeper penahan akses bila nomor urung diverifikasi
```

## Scoring Engine Algorithm

Sistem rekomendasi dijalankan dengan pendekatan hibrida (*hybrid approach*): gabungan **Content-Based** dan **Rule-Based Matching**.

Distribusi bobot penilaian (`StudentController@index`):
- **Subject match:** `+40` poin
- **Jenjang match:** `+25` poin
- **Harga dalam budget:** `+20` poin (Diberikan bonus proporsional tambahan eksponensial max 10 poin semakin murah dari budget)
- **Availability match:** `+15` poin
- **Gender match:** `+10` poin
- **Combo bonus (subject + jenjang matching strict):** `+20` poin ekstra
- **Experience bonus:** `*(pengalaman x 2) max 10` poin

Total skor akan diakumulasikan dan diurutkan (*Sort Descending*). Sehingga, pada antarmuka Siswa, guru-guru paling relevan dengan kebutuhan finansial dan akademiknya akan selalu tampil di urutan teratas.
