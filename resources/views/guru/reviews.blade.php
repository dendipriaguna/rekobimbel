@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Review & Rating" />

<div class="space-y-6">

    {{-- Ringkasan rating --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Rating</p>
            <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                {{ $reviews->count() > 0 ? number_format($reviews->avg('rating'), 1) : '-' }}/5
            </h3>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Review</p>
            <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $reviews->count() }}</h3>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Rating Tertinggi</p>
            <h3 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                {{ $reviews->count() > 0 ? $reviews->max('rating') : '-' }}
            </h3>
        </div>
    </div>

    {{-- Daftar review --}}
    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Ulasan dari Siswa</h3>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($reviews as $review)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $review->user->name }}</p>
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="text-yellow-400 text-sm">&#9733;</span>
                                @else
                                    <span class="text-gray-300 text-sm">&#9733;</span>
                                @endif
                            @endfor
                        </div>
                    </div>
                    @if($review->ulasan)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $review->ulasan }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Tidak ada ulasan.</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->format('d M Y, H:i') }}</p>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada review masuk.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
