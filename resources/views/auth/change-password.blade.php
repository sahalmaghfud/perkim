@extends('layouts.app') {{-- Ganti 'layouts.app' dengan nama file layout utama Anda --}}

@section('title', 'Ganti Password | SIPANDA')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <img src="{{ asset('asset/logo_pkp.png') }}" alt="Logo PKP" class="h-16 w-auto mx-auto mb-4">
                <h1 class="text-3xl font-bold text-gray-800 tracking-wider">SIPANDA</h1>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg w-full">
                <h2 class="text-2xl font-bold text-center mb-1 text-midnight_green">Ganti Password Anda</h2>
                <p class="text-center text-midnight_green/70 mb-8">Pastikan untuk menggunakan password yang kuat.</p>

                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.change') }}" class="space-y-6">
                    @csrf

                    <!-- Password Saat Ini -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat
                            Ini</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </span>
                            <input id="current_password" type="password" name="current_password" required
                                placeholder="••••••••"
                                class="w-full pl-10 p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-ecru text-midnight_green">
                        </div>
                        @error('current_password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-key text-gray-400"></i>
                            </span>
                            <input id="new_password" type="password" name="new_password" required
                                placeholder="Minimal 8 karakter"
                                class="w-full pl-10 p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-ecru text-midnight_green">
                        </div>
                        @error('new_password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="new_password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-key text-gray-400"></i>
                            </span>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" required
                                placeholder="Ulangi password baru"
                                class="w-full pl-10 p-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-ecru text-midnight_green">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-midnight_green hover:bg-midnight_green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ecru transition-transform transform hover:scale-105 duration-300">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
