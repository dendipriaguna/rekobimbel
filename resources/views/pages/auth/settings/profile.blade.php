@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Profile">
        <x-slot:breadcrumbs>
            <li>
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-500">Dashboard</a>
            </li>
            <li>
                <span class="text-gray-700 dark:text-gray-400">Profile</span>
            </li>
        </x-slot:breadcrumbs>
    </x-common.page-breadcrumb>

    <x-layouts.settings title="Profile" description="Update profil, foto, dan informasi akun kamu">
        @if (session('status'))
            <div class="mb-6">
                <x-ui.alert variant="success" :message="session('status')" />
            </div>
        @endif

        <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data" class="space-y-6"
            x-data="{
                photoPreview: null,
                handlePhoto(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.photoPreview = URL.createObjectURL(file);
                    }
                }
            }"
        >
            @csrf
            @method('PUT')

            <!-- Foto Profil -->
            <div>
                <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">Foto Profil</label>
                <div class="flex items-center gap-5">
                    <!-- Preview -->
                    <div class="relative h-50 w-50 shrink-0 overflow-hidden rounded-full border-2 border-gray-200 dark:border-gray-700">
                        <img
                            :src="photoPreview || '{{ $user->photoUrl() }}'"
                            alt="Foto Profil"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div>
                        <label for="photo-upload"
                            class="inline-flex cursor-pointer items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                            Pilih Foto
                        </label>
                        <input type="file" id="photo-upload" name="photo" accept="image/*" class="hidden"
                            @change="handlePhoto($event)" />
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-500">JPG, PNG, atau WebP. Maks 2MB.</p>
                    </div>
                </div>
                @error('photo')
                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name Input -->
            <div>
                <x-forms.input
                    name="name"
                    label="Nama"
                    type="text"
                    :value="$user->name"
                    required
                    autofocus
                />
            </div>

            <!-- Email Input -->
            <div>
                <x-forms.input
                    name="email"
                    label="Email"
                    type="email"
                    :value="$user->email"
                    required
                />
            </div>

            <!-- No HP (Editable) -->
            <div>
                <x-forms.input
                    name="phone"
                    label="No. WhatsApp"
                    type="tel"
                    :value="$user->phone"
                    required
                />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jika kamu mengubah nomor ini, kamu harus memverifikasi OTP lagi.</p>
            </div>

            <!-- 2FA Checkbox -->
            <div>
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="two_factor_enabled" value="1" {{ $user->two_factor_enabled ? 'checked' : '' }}
                        class="h-5 w-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:checked:bg-brand-500" />
                    <div>
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">Aktifkan 2-Step Verification</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-500">Minta kode OTP ke WhatsApp setiap kali login.</span>
                    </div>
                </label>
            </div>

            <!-- Save Button -->
            <div>
                <x-ui.button type="submit" variant="primary">
                    Simpan
                </x-ui.button>
            </div>
        </form>

        <!-- Delete Account Section -->
        <div class="mt-8 border-t border-gray-200 pt-8 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hapus Akun</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Hapus akun kamu beserta semua datanya</p>

            <form method="POST" action="{{ route('settings.profile.destroy') }}" class="mt-4"
                  onsubmit="return confirm('Yakin mau hapus akun? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <x-ui.button
                    type="submit"
                    variant="primary"
                    className="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800"
                >
                    Hapus Akun
                </x-ui.button>
            </form>
        </div>
    </x-layouts.settings>
@endsection

