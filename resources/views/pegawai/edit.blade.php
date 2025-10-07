@extends('layouts.app')

@section('title', 'Edit Data Pegawai')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Form tag di-update untuk method PUT --}}
        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Header Halaman --}}
            <div
                class="relative bg-gradient-midnight-green text-white rounded-2xl shadow-xl p-6 md:p-8 overflow-hidden mb-8">
                <i
                    class="fas fa-user-edit absolute -right-8 -bottom-12 text-midnight_green-400/30 text-9xl transform rotate-[-15deg]"></i>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight">Edit Data Pegawai</h1>
                        <p class="mt-1 text-midnight_green-900/80">Memperbarui profil untuk: <span
                                class="font-semibold">{{ $pegawai->nama }}</span></p>
                    </div>
                </div>
            </div>

            {{-- Include Form Partial --}}
            {{-- Variabel $pegawai, $pangkats, dan $bidangs akan otomatis terisi dari controller --}}
            @include('pegawai._form')

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-6 py-3 bg-white/80 border-2 border-transparent rounded-lg font-semibold text-xs text-midnight_green uppercase tracking-widest shadow-md hover:bg-white transition-all duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-ecru-500 border border-transparent rounded-lg font-semibold text-xs text-midnight_green-100 uppercase tracking-widest shadow-md hover:bg-ecru-600 hover:shadow-lg hover:-translate-y-px focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ecru transition-all duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
@endsection
