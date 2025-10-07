<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIPANDA</title>

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Pastikan font ini diimpor di app.css utama Anda */
        /* @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); */

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animasi untuk background slider */
        @keyframes slideBackground {

            0%,
            45% {
                background-image: var(--bg-image1);
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            55%,
            100% {
                background-image: var(--bg-image2);
                opacity: 1;
            }
        }

        #background-slider {
            background-size: cover;
            background-position: center;
            animation: slideBackground 14s linear infinite;
        }
    </style>
</head>

<body>

    <div id="background-slider" class="fixed inset-0 z-[-1]"
        style="--bg-image1: url('{{ asset('asset/image1.png') }}'); --bg-image2: url('{{ asset('asset/image2.png') }}');">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-md">

            <div class="text-center mb-8" style="text-shadow: 0px 1px 3px rgba(0, 0, 0, 0.4);">
                <img src="{{ asset('asset/logo_pkp.png') }}" alt="Logo PKP"
                    class="h-20 w-auto mx-auto mb-4 drop-shadow-lg">
                <h1 class="text-4xl font-bold text-white tracking-wider">SIPANDA</h1>
                <p class="text-white/80 mt-1">Sistem Manajemen Surat & Dokumen</p>
            </div>

            <div class="bg-white/50 backdrop-blur-md p-8 rounded-2xl shadow-xl w-full">
                <h2 class="text-2xl font-bold text-center mb-1 text-midnight_green">Selamat Datang Kembali</h2>
                <p class="text-center text-midnight_green/70 mb-8">Silakan masuk ke akun Anda.</p>

                <!-- Diubah: Pengecekan error diubah dari 'email' ke 'name' -->
                @if ($errors->any() && !$errors->has('name') && !$errors->has('password'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md" role="alert">
                        <p class="font-bold">Login Gagal!</p>
                        <p>Kredensial yang Anda masukkan tidak cocok.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- === BLOK INPUT NAMA PENGGUNA (DIUBAH DARI EMAIL) === -->
                    <div>
                        <!-- Diubah: Label diubah ke "Nama Pengguna" -->
                        <label for="name" class="block text-sm font-medium text-midnight_green-300 mb-1">Nama
                            Pengguna</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <!-- Diubah: Ikon diubah menjadi ikon pengguna -->
                                <i class="fas fa-user text-midnight_green/50"></i>
                            </span>
                            <!-- Diubah: Atribut id, type, name, value, dan placeholder disesuaikan untuk 'name' -->
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus placeholder="Masukkan nama pengguna"
                                class="w-full pl-10 p-3 bg-white/60 border border-midnight_green/20 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-ecru text-midnight_green placeholder-midnight_green/60 transition">
                        </div>
                        <!-- Diubah: Error handling untuk field 'name' -->
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>
                    <!-- === AKHIR BLOK INPUT NAMA PENGGUNA === -->

                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-midnight_green-300 mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-midnight_green/50"></i>
                            </span>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-10 p-3 bg-white/60 border border-midnight_green/20 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-ecru text-midnight_green placeholder-midnight_green/60 transition">
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-midnight_green hover:bg-midnight_green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ecru transition-transform transform hover:scale-105 duration-300">
                            Log in
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

</html>
