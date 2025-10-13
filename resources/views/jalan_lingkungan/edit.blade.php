@extends('layouts.app')

@section('title', 'Edit Data Jalan Lingkungan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-edit absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10">
                <h3 class="text-2xl font-bold tracking-tight">
                    Edit Data Pekerjaan
                </h3>
                <p class="mt-1 text-midnight_green-900/80 text-sm truncate">Mengubah detail untuk:
                    {{ $jalanLingkungan->uraian }}</p>
            </div>
        </div>

        {{-- Konten Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">
            <form action="{{ route('jalan_lingkungan.update', $jalanLingkungan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('jalan_lingkungan._form')
            </form>
        </div>

    </div>
@endsection
