@extends('layouts.app')

@section('content')
    <div class="w-full">

        {{-- Header Halaman --}}
        {{-- Warna border diubah agar terlihat di background gelap --}}
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-700">
            {{-- Warna font judul diubah menjadi terang --}}
            <h2 class="text-2xl font-bold text-blue-700">Edit Siteplan</h2>
            <a href="{{ route('siteplans.index') }}"
                class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                Kembali
            </a>
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
        <form action="{{ route('siteplans.update', $siteplan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('siteplans._form')

            <div class="text-center mt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg transition duration-300 ease-in-out">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
@endsection
