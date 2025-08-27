<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIMASDOK</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /*
         JavaScript Anda menggunakan kelas .show dan .rotate.
         Daripada mengubah JS, kita definisikan kelas ini di sini agar tetap berfungsi.
        */
        .dropdown-menu.show {
            max-height: 200px;
            /* Atau nilai yang lebih besar jika perlu */
        }

        .dropdown-icon.rotate {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">

    <div class="relative min-h-screen md:flex">

        <aside
            class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-72 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">

            <div class="p-5 text-center border-b border-white/10">
                <i class="fas fa-building fa-2x"></i>
                <h2 class="text-xl font-semibold mt-2">SIMASDOK</h2>
                <p class="text-sm opacity-80">Sistem Manajemen Surat & Dokumen</p>
                <div class="mt-4 font-semibold text-base">
                    {{ Auth::user()->name }}
                </div>
            </div>

            <nav class="py-5">
                <a href="#"
                    class="flex items-center py-3 px-5 border-l-4 border-l-white bg-white/10 translate-x-1 transition-all duration-300">
                    <i class="fas fa-home w-5 mr-3"></i>
                    Dashboard
                </a>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-building w-5 mr-3"></i>
                            Perumahan
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-white/5 transition-all duration-300 ease-in-out">
                        <a href="{{ route('surat.divisi', 'Perumahan') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-city w-5 mr-3"></i>
                            Permukiman
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-white/5 transition-all duration-300 ease-in-out">
                        <a href="{{ route('surat.divisi', 'Permukiman') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-road w-5 mr-3"></i>
                            PSU
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-white/5 transition-all duration-300 ease-in-out">
                        <a href="{{ route('surat.divisi', 'PSU') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-clipboard-list w-5 mr-3"></i>
                            TU
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-white/5 transition-all duration-300 ease-in-out">
                        <a href="{{ route('surat.divisi', 'TU') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                    </div>
                </div>

            </nav>
        </aside>

        <main class="flex-1 p-5 md:p-8">
            <header class="bg-white p-5 rounded-lg shadow-md mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">@yield('header-title', 'Dashboard')</h1>
                    <p class="text-gray-500 mt-1">Selamat datang kembali!</p>
                </div>
                <div class="flex items-center gap-4">
                    <i class="fas fa-user-circle text-3xl text-gray-500"></i>
                    <div>
                        <div class="font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                    </div>
                </div>
            </header>

            @yield('content')

        </main>
    </div>
    @stack('scripts')

    {{-- ... SEMUA JAVASCRIPT ANDA TETAP SAMA DI BAWAH SINI ... --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();

                    const dropdown = this.parentElement.querySelector('.dropdown-menu');
                    const icon = this.querySelector('.dropdown-icon');

                    const isActive = dropdown.classList.contains('show');

                    document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList
                        .remove('show'));
                    document.querySelectorAll('.dropdown-icon').forEach(ico => ico.classList.remove(
                        'rotate'));

                    if (!isActive) {
                        dropdown.classList.add('show');
                        if (icon) icon.classList.add('rotate');
                    }
                });
            });

            window.addEventListener('click', function(e) {
                if (!e.target.closest('[data-toggle="dropdown"]')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove(
                        'show'));
                    document.querySelectorAll('.dropdown-icon').forEach(ico => ico.classList.remove(
                        'rotate'));
                }
            });
        });
    </script>
</body>

</html>
