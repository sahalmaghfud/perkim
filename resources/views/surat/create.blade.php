@extends('layouts.app')

@section('title', 'Tambah Surat Baru')
@section('header-title', 'Tambah Surat Baru')

@section('content')
<div class="content-section">
    <div class="section-header">
        <h3>Formulir Surat Baru</h3>
    </div>
    <div style="padding: 20px;">
        {{-- Anda perlu membuat view `_form.blade.php` seperti di jawaban sebelumnya --}}
        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('surat._form')
        </form>
    </div>
</div>
@endsection
