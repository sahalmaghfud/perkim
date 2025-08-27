@extends('layouts.app')

@section('title', 'Edit Surat')

@section('content')
<h1>Edit Surat: {{ $surat->nomor_surat }}</h1>
<form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('surat._form')
</form>
@endsection
