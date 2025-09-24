@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Data Pegawai</h1>
        </div>

        <!-- Card Form -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                @include('pegawai._form', ['tombol_submit' => 'Update Data'])

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-base font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $tombol_submit ?? 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
