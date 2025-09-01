@extends('layouts.app')

@section('title', 'Edit Dokumen')

@section('header-title', 'Edit Dokumen')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">
            Edit Dokumen: <span class="font-normal">{{ $dokumen->judul }}</span>
        </h3>

        <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Meng-include komponen form yang sudah dibuat sebelumnya --}}
            @include('dokumen._form')
        </form>
    </div>
@endsection
