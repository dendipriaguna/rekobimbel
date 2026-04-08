@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Booking Jadwal" />

<div class="space-y-6">
    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Booking dengan {{ $teacher->user->name }}</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $teacher->subject }} - {{ $teacher->jenjang }}</p>
        </div>

        <form action="{{ route('jadwal.store') }}" method="POST" class="p-6"
            x-data="{
                jamMulai: '{{ old('jam_mulai', '') }}',
                jamSelesai: '{{ old('jam_selesai', '') }}',
                hitungJamSelesai() {
                    if (!this.jamMulai) { this.jamSelesai = ''; return; }
                    const [h, m] = this.jamMulai.split(':').map(Number);
                    const endH = (h + 1) % 24;
                    this.jamSelesai = String(endH).padStart(2, '0') + ':' + String(m).padStart(2, '0');
                }
            }"
            x-init="hitungJamSelesai()"
        >
            @csrf
            <input type="hidden" name="teacher_profile_id" value="{{ $teacher->id }}">

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-400">
                    Ada beberapa kesalahan dalam isian form kamu, silakan periksa di bawah.
                </div>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                {{-- Tanggal --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal <span class="text-error-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('tanggal') border-error-500 @enderror" />
                    @error('tanggal')
                        <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jam Mulai <span class="text-error-500">*</span></label>
                    <input type="time" name="jam_mulai" x-model="jamMulai" @change="hitungJamSelesai()" required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('jam_mulai') border-error-500 @enderror" />
                    @error('jam_mulai')
                        <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Selesai (auto-fill, readonly) --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jam Selesai <span class="text-xs text-gray-400">(otomatis +1 jam)</span></label>
                    <input type="time" name="jam_selesai" x-model="jamSelesai" readonly required
                        class="h-11 w-full rounded-lg border border-gray-300 bg-gray-50 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 cursor-not-allowed @error('jam_selesai') border-error-500 @enderror" />
                    @error('jam_selesai')
                        <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Catatan --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Catatan</label>
                <textarea name="catatan" rows="3" placeholder="Materi yang mau dipelajari"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white @error('catatan') border-error-500 @enderror">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-brand-500 hover:bg-brand-600 rounded-lg px-5 py-3 text-sm font-medium text-white">
                    Booking Sekarang
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

