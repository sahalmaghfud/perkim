@extends('layouts.app')

@section('title', 'Tambah Dokumen Baru')

@section('header-title', 'Tambah Dokumen Baru')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-white border-b pb-4 mb-6">
            Formulir Dokumen Baru
        </h3>

        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('dokumen._form')
        </form>
    </div>
@endsection
