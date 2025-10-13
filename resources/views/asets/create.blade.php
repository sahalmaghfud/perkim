@extends('layouts.app')

@section('title', 'Tambah Aset Baru')

@section('content')
    {{-- Header Halaman --}}
    <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
        <i
            class="fas fa-plus-circle absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold tracking-tight">
                Tambah Aset Baru
            </h3>
            <p class="mt-1 text-midnight_green-100/80 text-sm">Isi formulir di bawah ini untuk menambahkan data baru.</p>
        </div>
    </div>

    {{-- Konten Form --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">
        <form action="{{ route('asets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('asets._form')
        </form>
    </div>
@endsection
