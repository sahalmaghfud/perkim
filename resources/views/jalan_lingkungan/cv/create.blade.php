@extends('layouts.app')

@section('title', 'Tambah CV Baru')
@section('header-title', 'Tambah CV Baru')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-midnight_green mr-3"></i>
            Formulir Penambahan CV
        </h3>

        <form action="{{ route('cv.store') }}" method="POST">
            {{-- Memuat form partial. Tidak perlu mengirim variabel $cv karena ini form baru. --}}
            @include('jalan_lingkungan.cv._form')

            {{-- Baris Tombol Aksi Form --}}
            <div class="flex justify-start gap-3 mt-8">
                <button type="submit"
                    class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <a href="{{ route('cv.index') }}"
                    class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-2 px-5 rounded-lg transition-all duration-300 border border-gray-300 shadow-sm transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
