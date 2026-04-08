@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Dashboard" />

<div class="space-y-6">

    @session('success')
        <x-ui.alert variant="success">
            {{ $value }}
        </x-ui.alert>
    @endsession

    {{-- Admin Dashboard --}}
    @if(auth()->user()->role === 'admin')
        {{-- Metrics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total User</p>
                <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</h3>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Guru</p>
                <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalGuru }}</h3>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</p>
                <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalSiswa }}</h3>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                <p class="text-sm text-gray-500 dark:text-gray-400">Guru Pending</p>
                <h3 class="mt-1 text-2xl font-bold text-orange-500">{{ $pendingGuru }}</h3>
            </div>
        </div>

        {{-- Daftar Guru --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Daftar Guru</h3>
            </div>
            <div class="max-w-full overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jenjang</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pendidikan</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Pengalaman</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Harga</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruProfiles as $guru)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $guru->user->name }}</td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $guru->subject }}</td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $guru->jenjang }}</td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $guru->education }}</td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $guru->experience }}</td>
                                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">Rp {{ number_format($guru->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    @if($guru->status === 'approved')
                                        <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                    @elseif($guru->status === 'pending')
                                        <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">Pending</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($guru->status !== 'approved')
                                            <form action="{{ route('guru.approve', $guru->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-green-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-600">Approve</button>
                                            </form>
                                        @endif
                                        @if($guru->status !== 'rejected')
                                            <form action="{{ route('guru.reject', $guru->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="rounded-lg bg-red-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-600">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada guru terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Guru Dashboard --}}
    @if(auth()->user()->role === 'guru')

        {{-- Info status visibility --}}
        @if($profile)
            @if($profile->status === 'approved')
                <div class="rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                    <p class="text-sm text-green-700 dark:text-green-400">Profil kamu aktif dan bisa dilihat oleh siswa.</p>
                </div>
            @elseif($profile->status === 'pending')
                <div class="rounded-xl border border-orange-200 bg-orange-50 p-4 dark:border-orange-800 dark:bg-orange-900/20">
                    <p class="text-sm text-orange-700 dark:text-orange-400">Profil kamu sedang ditinjau oleh admin. Sabar ya.</p>
                </div>
            @else
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                    <p class="text-sm text-red-700 dark:text-red-400">Profil kamu ditolak. Silakan edit dan ajukan ulang.</p>
                </div>
            @endif
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Profil Guru Kamu</h3>
                @if($profile)
                    <a href="{{ route('guru.profil.edit') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        Edit Profil
                    </a>
                @endif
            </div>

            @if($profile)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mata Pelajaran</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->subject }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jenjang</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->jenjang }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengalaman</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->experience }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pendidikan</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->education }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Harga per Sesi</p>
                        <p class="font-medium text-gray-800 dark:text-white">Rp {{ number_format($profile->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ketersediaan</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->availability }}</p>
                    </div>
                </div>

                @if($profile->detail)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Detail</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $profile->detail }}</p>
                    </div>
                @endif
            @else
                <p class="text-gray-500 dark:text-gray-400 mb-4">Kamu belum mengisi profil guru.</p>
                <a href="{{ route('guru.profil.create') }}"
                    class="bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2.5 text-sm font-medium text-white">
                    Isi Profil Sekarang
                </a>
            @endif
        </div>
    @endif

    {{-- Siswa Dashboard --}}
    @if(auth()->user()->role === 'siswa')

        @if($preference)
            {{-- Jika sudah memiliki preferensi, langsung tampilkan hasil scoring --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Rekomendasi Guru</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Preferensi: {{ $preference->subject ?? '-' }} / {{ $preference->jenjang ?? '-' }} / Maks Rp {{ number_format($preference->max_price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('preferensi.edit') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        Edit Preferensi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($teachers as $teacher)
                    <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $teacher->user->photoUrl() }}" alt="{{ $teacher->user->name }}"
                                    class="h-30 w-30 rounded-full object-cover border border-gray-200 dark:border-gray-700" />
                                <h4 class="font-semibold text-gray-800 dark:text-white">{{ $teacher->user->name }}</h4>
                            </div>
                            @if(isset($teacher->score))
                                <span class="rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-medium text-brand-600 dark:bg-brand-900/30 dark:text-brand-400">
                                    Skor: {{ $teacher->score }}
                                </span>
                            @endif
                        </div>
                        <div class="space-y-1.5 text-sm">
                            <p class="text-gray-500 dark:text-gray-400">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $teacher->subject }}</span> - {{ $teacher->jenjang }}
                            </p>
                            <p class="text-gray-500 dark:text-gray-400">Pengalaman: {{ $teacher->experience }}</p>
                            <p class="text-gray-500 dark:text-gray-400">Harga: Rp {{ number_format($teacher->price, 0, ',', '.') }}/sesi</p>
                            <p class="text-gray-500 dark:text-gray-400">Jadwal: {{ $teacher->availability }}</p>
                            @if($teacher->detail)
                                <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">{{ $teacher->detail }}</p>
                            @endif

                            {{-- Rating rata-rata --}}
                            @php
                                $avgRating = $teacher->reviews->avg('rating');
                                $totalReview = $teacher->reviews->count();
                            @endphp
                            @if($totalReview > 0)
                                <p class="text-gray-500 dark:text-gray-400">
                                    Rating: {{ number_format($avgRating, 1) }}/5 ({{ $totalReview }} review)
                                </p>
                            @endif
                        </div>

                        {{-- Tombol aksi --}}
                        <div class="mt-3 flex items-center gap-2 border-t border-gray-100 pt-3 dark:border-gray-800">
                            <a href="{{ route('jadwal.create', $teacher->id) }}"
                                class="bg-brand-500 hover:bg-brand-600 rounded-lg px-3 py-1.5 text-xs font-medium text-white">
                                Booking
                            </a>

                            {{-- Tombol review hanya muncul jika memiliki jadwal selesai --}}
                            @php
                                $sudahReview = $teacher->reviews->where('user_id', auth()->id())->count() > 0;
                                $punyaJadwalSelesai = $teacher->schedules->where('user_id', auth()->id())->where('status', 'selesai')->count() > 0;
                            @endphp
                            @if($punyaJadwalSelesai && !$sudahReview)
                                <button type="button" onclick="document.getElementById('review-{{ $teacher->id }}').classList.toggle('hidden')"
                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                                    Review
                                </button>
                            @elseif($sudahReview)
                                <span class="text-xs text-gray-400">Sudah direview</span>
                            @endif
                        </div>

                        {{-- Form review (hidden by default) --}}
                        @if($punyaJadwalSelesai && !$sudahReview)
                            <div id="review-{{ $teacher->id }}" class="hidden mt-3 border-t border-gray-100 pt-3 dark:border-gray-800">
                                <form action="{{ route('review.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="teacher_profile_id" value="{{ $teacher->id }}">
                                    <div class="flex items-center gap-2 mb-2">
                                        <label class="text-xs text-gray-500 dark:text-gray-400">Rating:</label>
                                        <select name="rating" required class="h-8 rounded-lg border border-gray-300 px-2 text-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                            <option value="5">5</option>
                                            <option value="4">4</option>
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <textarea name="ulasan" rows="2" placeholder="Tulis ulasan..." class="w-full rounded-lg border border-gray-300 px-3 py-2 text-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                                    <button type="submit" class="mt-2 bg-brand-500 hover:bg-brand-600 rounded-lg px-3 py-1.5 text-xs font-medium text-white">Kirim Review</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum ada guru yang tersedia.
                    </div>
                @endforelse
            </div>
        @else
            {{-- Belum punya preferensi --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Selamat Datang!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Kamu belum mengisi preferensi. Isi dulu biar kami bisa rekomendasikan guru yang paling cocok.</p>
                <a href="{{ route('preferensi.create') }}"
                    class="bg-brand-500 hover:bg-brand-600 rounded-lg px-4 py-2.5 text-sm font-medium text-white">
                    Isi Preferensi
                </a>
            </div>
        @endif

    @endif

</div>
@endsection