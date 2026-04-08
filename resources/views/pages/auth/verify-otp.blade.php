@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                            Verifikasi OTP
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Masukkan kode 6 digit yang dikirim ke WhatsApp {{ auth()->user()->phone }}
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('otp.verify.submit') }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Kode OTP<span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="otp_code" maxlength="6" placeholder="Masukkan 6 digit kode OTP" autofocus
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 tracking-[0.5em] text-center text-lg font-bold @error('otp_code') border-error-500 @enderror" />
                                @error('otp_code')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-5">
                        <form method="POST" action="{{ route('otp.resend') }}">
                            @csrf
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                Belum dapat kode?
                                <button type="submit" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Kirim Ulang OTP</button>
                            </p>
                        </form>
                    </div>

                    <!-- Ganti Nomor HP -->
                    <div class="mt-4 border-t border-gray-100 pt-4 dark:border-gray-800" x-data="{ showChangePhone: false }">
                        <button type="button" @click="showChangePhone = !showChangePhone" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            Salah nomor WhatsApp? Ganti di sini
                        </button>
                        
                        <div x-show="showChangePhone" x-transition class="mt-3">
                            <form method="POST" action="{{ route('otp.change.phone') }}" class="flex gap-2">
                                @csrf
                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}" required placeholder="628..."
                                    class="h-10 flex-1 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white" />
                                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    Simpan
                                </button>
                            </form>
                            @error('phone')
                                <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex items-center justify-center">
                    <x-common.common-grid-shape />
                    <div class="flex max-w-xs flex-col items-center">
                        <a href="{{ route('dashboard') }}" class="mb-4 block">
                            <img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" />
                        </a>
                        <p class="text-center text-gray-400 dark:text-white/60">
                            Verifikasi nomor WhatsApp untuk melanjutkan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
