@extends('layouts.app') {{-- ganti sesuai nama layout TailAdmin lo --}}

@section('content')
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">

        {{-- Header Card --}}
        <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">
                Kirim WhatsApp via Fonnte
            </h3>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mx-6.5 mt-5 flex border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-4">
                <p class="text-[#34D399]">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if(session('error'))
            <div class="mx-6.5 mt-5 flex border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-4">
                <p class="text-[#F87171]">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('wa.send') }}" method="POST" class="flex flex-col gap-5.5 p-6.5">
            @csrf

            {{-- Input Nomor --}}
            <div>
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    Nomor Tujuan
                </label>
                <input type="text" name="target" value="{{ old('target') }}" placeholder="628123456789"
                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white" />
                @error('target')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Pesan --}}
            <div>
                <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                    Pesan
                </label>
                <textarea name="message" rows="6" placeholder="Ketik pesan lo di sini..."
                    class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 text-black outline-none transition focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90 transition">
                Kirim WhatsApp 🚀
            </button>

        </form>
    </div>
@endsection