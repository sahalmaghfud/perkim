@extends('layouts.app')

@section('title', 'Edit Data RTLH')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-edit absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        Edit Data RTLH
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm">Mengubah detail untuk:
                        {{ $rumahTidakLayakHuni->nama_kepala_ruta }}</p>
                </div>
                <a href="{{ route('rtlh.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-midnight_green-500 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Konten Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">
            <form action="{{ route('rtlh.update', $rumahTidakLayakHuni->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('rtlh._form')
            </form>
        </div>

    </div>
@endsection
