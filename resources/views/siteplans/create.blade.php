@extends('layouts.app')

@section('content')
    <div class="w-full">

        {{-- Header Halaman --}}
        {{-- Warna border diubah agar terlihat di background gelap --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i class=" absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        Tambah Siteplan Baru
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm">Isi formulir untuk menambahkan data siteplan baru.</p>
                </div>
                <a href="{{ route('siteplans.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/10 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-white/20 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Notifikasi Error (versi dark mode) --}}
        @if ($errors->any())
            {{-- Background diubah menjadi merah gelap transparan, teks menjadi merah terang --}}
            <div class="bg-red-500/10 border-l-4 border-red-500 text-red-200 p-4 mb-6" role="alert">
                <p class="font-bold">Oops! Ada masalah dengan input Anda.</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('siteplans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('siteplans._form', ['siteplan' => new \App\Models\Siteplan()])


    </div>
    </form>
    </div>
@endsection
