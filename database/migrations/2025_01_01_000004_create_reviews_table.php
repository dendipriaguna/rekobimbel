<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk tabel rating dan ulasan guru
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // siswa yang kasih rating
            $table->foreignId('teacher_profile_id')->constrained()->onDelete('cascade'); // guru yang dirating
            $table->integer('rating'); // 1-5
            $table->text('ulasan')->nullable(); // komentar dari siswa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
