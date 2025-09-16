@extends('layouts.app') {{-- Ganti sesuai nama layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Pegawai</h1>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('pegawai._form', ['tombol_submit' => 'Update Data'])
            </form>
        </div>

    </div>
@endsection
