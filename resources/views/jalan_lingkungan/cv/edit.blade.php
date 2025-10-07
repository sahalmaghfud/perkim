@extends('layouts.app')

@section('title', 'Edit Data CV')
@section('header-title', 'Edit Data CV')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-6 flex items-center">
            <i class="fas fa-pencil-alt text-midnight_green mr-3"></i>
            Formulir Perubahan Data CV
        </h3>

        <form action="{{ route('cv.update', $cv->id) }}" method="POST">
            @method('PUT')
            {{-- Memuat form partial dan mengirimkan data $cv untuk diisi ke dalam form. --}}
            @include('jalan_lingkungan.cv._form', ['cv' => $cv])

            {{-- Baris Tombol Aksi Form --}}
            <div class="flex justify-start gap-3 mt-8">
                <button type="submit"
                    class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                    <i class="fas fa-sync-alt mr-2"></i> Update
                </button>
                <a href="{{ route('cv.index') }}"
                    class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-2 px-5 rounded-lg transition-all duration-300 border border-gray-300 shadow-sm transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
