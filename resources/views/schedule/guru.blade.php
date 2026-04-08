@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Jadwal Masuk" />

<div class="space-y-6">

    @session('success')
        <x-ui.alert variant="success">
            {{ $value }}
        </x-ui.alert>
    @endsession

    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Jadwal Belajar Masuk</h3>
        </div>
        <div class="max-w-full overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Siswa</th>
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jam</th>
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Catatan</th>
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $jadwal)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $jadwal->user->name }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->tanggal }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->catatan ?? '-' }}</td>
                            <td class="px-5 py-4">
                                @if($jadwal->status === 'confirmed')
                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">Confirmed</span>
                                @elseif($jadwal->status === 'pending')
                                    <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">Pending</span>
                                @elseif($jadwal->status === 'selesai')
                                    <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Selesai</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">Batal</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    @if($jadwal->status === 'pending')
                                        <form action="{{ route('jadwal.confirm', $jadwal->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-green-600 hover:underline">Konfirmasi</button>
                                        </form>
                                        <form action="{{ route('jadwal.cancel', $jadwal->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-red-500 hover:underline">Tolak</button>
                                        </form>
                                    @elseif($jadwal->status === 'confirmed')
                                        <form action="{{ route('jadwal.complete', $jadwal->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-blue-600 hover:underline">Selesai</button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada jadwal masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
