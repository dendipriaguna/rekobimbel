@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Preferensi Guru" />

<div class="space-y-6">

    @session('success')
        <x-ui.alert variant="success">
            {{ $value }}
        </x-ui.alert>
    @endsession

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Isi Preferensi Kamu</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Data ini akan digunakan untuk mencocokkan guru yang paling sesuai.</p>
        </div>

        {{-- Cek apakah lagi edit atau buat baru --}}
        <form action="{{ isset($preference) ? route('preferensi.update') : route('preferensi.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($preference))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                {{-- Mata Pelajaran --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Mata Pelajaran</label>
                    <input type="text" name="subject" value="{{ old('subject', $preference->subject ?? '') }}" placeholder="Contoh: Matematika"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                {{-- Jenjang --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenjang</label>
                    <select name="jenjang"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Semua Jenjang</option>
                        <option value="SD" {{ old('jenjang', $preference->jenjang ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('jenjang', $preference->jenjang ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ old('jenjang', $preference->jenjang ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                </div>

                {{-- Maks Harga --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Maksimal Harga per Sesi (Rp)</label>
                    <input type="number" name="max_price" value="{{ old('max_price', $preference->max_price ?? '') }}" placeholder="100000"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                {{-- Gender --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Preferensi Gender Guru</label>
                    <select name="gender"
                        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="">Tidak Ada Preferensi</option>
                        <option value="laki-laki" {{ old('gender', $preference->gender ?? '') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('gender', $preference->gender ?? '') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Ketersediaan --}}
               <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Ketersediaan Waktu
                </label>

                <div class="grid grid-cols-2 gap-2">
                    @php
                        $days = ['Senin','Selasa','Rabu','Kamis',"Jumat",'Sabtu','Minggu'];
                        $selectedDays = old('availability', isset($preference->availability) 
                            ? (is_array($preference->availability) 
                                ? $preference->availability 
                                : explode(', ', $preference->availability)) 
                            : []);
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

            {{-- Submit --}}
            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 rounded-lg px-5 py-3 text-sm font-medium text-white">
                    {{ isset($preference) ? 'Update Preferensi' : 'Simpan Preferensi' }}
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
