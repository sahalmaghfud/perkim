{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') di layout --}}
@section('title', 'Dashboard')

@section('header-title', 'Dashboard Manajemen Dokumen')

{{-- Mengisi @yield('content') di layout --}}
@section('content')
@endsection

@push('scripts')
@endpush
