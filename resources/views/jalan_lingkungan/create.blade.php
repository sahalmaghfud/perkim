@extends('layouts.app')

@section('title', 'Tambah Data Jalan Lingkungan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-plus-circle absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <h3 class="text-2xl font-bold tracking-tight">
                    Tambah Data Pekerjaan Baru
                </h3>
                <p class="mt-1 text-midnight_green-900/80 text-sm">Isi formulir di bawah ini untuk menambahkan data pekerjaan
                    jalan lingkungan baru.</p>
            </div>
        </div>

        {{-- Konten Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">
            <form action="{{ route('jalan_lingkungan.store') }}" method="POST">
                @csrf
                @include('jalan_lingkungan._form')
            </form>
        </div>

    </div>
@endsection
