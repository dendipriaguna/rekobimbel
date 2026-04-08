@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="{{ isset($profile) ? 'Edit Profil Guru' : 'Isi Profil Guru' }}" />

<div class="space-y-6">

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                {{ isset($profile) ? 'Edit Profil' : 'Form Profil Guru' }}
            </h3>
        </div>

        <form action="{{ isset($profile) ? route('guru.profil.update') : route('guru.profil.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($profile))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                {{-- Mata Pelajaran --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Mata Pelajaran <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="subject" value="{{ old('subject', $profile->subject ?? '') }}" placeholder="Contoh: Matematika" required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                {{-- Jenjang --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Jenjang <span class="text-error-500">*</span>
                    </label>
                    <select name="jenjang" required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Pilih Jenjang</option>
                        <option value="SD" {{ old('jenjang', $profile->jenjang ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('jenjang', $profile->jenjang ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('jenjang', $profile->jenjang ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                </div>

                {{-- Pengalaman --}}
             <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Pengalaman
    </label>

    <div class="flex items-center gap-3">
        <!-- Tahun -->
        <div class="flex items-center">
            <input 
                type="number" 
                name="experience_years"
                min="0" 
                max="60"
                value="{{ old('experience_years', $profile->experience_years ?? 0) }}"
                class="h-11 w-20 rounded-lg border border-gray-300 px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            />
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">tahun</span>
        </div>

        <!-- Bulan -->
        <div class="flex items-center">
            <input 
                type="number" 
                name="experience_months"
                min="0" 
                max="12"
                value="{{ old('experience_months', $profile->experience_months ?? 0) }}"
                class="h-11 w-20 rounded-lg border border-gray-300 px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
            />
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">bulan</span>
        </div>
    </div>
</div>
                {{-- Pendidikan --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pendidikan</label>
                    <input type="text" name="education" value="{{ old('education', $profile->education ?? '') }}" placeholder="Contoh: S1 Pendidikan Matematika"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                {{-- Harga --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Harga per Sesi (Rp) <span class="text-error-500">*</span>
                    </label>
                    <input type="number" name="price" value="{{ old('price', $profile->price ?? '') }}" placeholder="75000" required
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>


                {{-- Ketersediaan --}}
               <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Ketersediaan
            </label>

            <div class="grid grid-cols-2 gap-2">
                @php
                    $days = ['Senin','Selasa','Rabu','Kamis',"Jumat",'Sabtu','Minggu'];
                    $selectedDays = old('availability', isset($profile->availability) ? explode(', ', $profile->availability) : []);
                @endphp

                @foreach($days as $day)
                    <label class="flex items-center gap-2">
                        <input 
                            type="checkbox" 
                            name="availability[]" 
                            value="{{ $day }}"
                            {{ in_array($day, $selectedDays) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                        >
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $day }}</span>
                    </label>
                @endforeach
            </div>
        </div>

                {{-- Gender --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Gender</label>
                    <select name="gender"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Pilih Gender</option>
                        <option value="laki-laki" {{ old('gender', $profile->gender ?? '') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('gender', $profile->gender ?? '') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            {{-- Detail --}}
            <div class="mt-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Detail Tambahan</label>
                <textarea name="detail" rows="3" placeholder="Ceritakan tentang gaya mengajar kamu"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">{{ old('detail', $profile->detail ?? '') }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 rounded-lg px-5 py-3 text-sm font-medium text-white">
                    {{ isset($profile) ? 'Update Profil' : 'Simpan Profil' }}
                </button>
                <a href="{{ route('dashboard') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
