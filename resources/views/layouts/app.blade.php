<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') SIPanda</title>

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

        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-20 md:hidden hidden"></div>

        <aside id="sidebar"
            class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-72 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto z-30">

            <div class="p-5 text-center border-b border-white/10">
                <i class="fas fa-building fa-2x"></i>
                <h2 class="text-xl font-semibold mt-2">SIPANDA</h2>
                <p class="text-sm opacity-80">Sistem Manajemen Surat & Dokumen</p>
                <div class="mt-4 font-semibold text-base">
                    {{ Auth::user()->name }}
                </div>
            </div>

            <nav class="py-5">
                {{-- Link Dashboard --}}
                <a href="/dashboard"
                    class="flex items-center py-3 px-5 border-l-4 {{ request()->is('dashboard') ? 'border-l-white bg-white/10 translate-x-1' : 'border-transparent' }} hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300">
                    <i class="fas fa-home w-5 mr-3"></i>
                    Dashboard
                </a>
                <a href="/pegawai"
                    class="flex items-center py-3 px-5 border-l-4 {{ request()->is('dashboard') ? 'border-l-white bg-white/10 translate-x-1' : 'border-transparent' }} hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300">
                    <i class="fas fa-users  w-5 mr-3"></i>
                    Data Staff
                </a>

                {{-- Dropdown Divisi Perumahan --}}
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
                        <a href="{{ route('surat.divisi', 'perumahan') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                        <a href="{{ route('dokumen.divisi', 'perumahan') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                    </div>
                </div>

                {{-- Dropdown Divisi Permukiman --}}
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
                        <a href="{{ route('surat.divisi', 'permukiman') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                        <a href="{{ route('dokumen.divisi', 'permukiman') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                    </div>
                </div>

                {{-- Dropdown Divisi PSU --}}
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
                        <a href="{{ route('surat.divisi', 'psu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                        <a href="{{ route('dokumen.divisi', 'psu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                    </div>
                </div>

                {{-- Dropdown Divisi TU --}}
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
                        <a href="{{ route('surat.divisi', 'tu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-envelope w-4 mr-2"></i> Surat
                        </a>
                        <a href="{{ route('dokumen.divisi', 'tu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                    </div>
                </div>

            </nav>
        </aside>

        <main class="flex-1 p-5 md:p-8">
            <header class="bg-white p-5 rounded-lg shadow-md mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="text-gray-600 md:hidden">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">@yield('header-title', 'Dashboard')</h1>
                        <p class="text-gray-500 mt-1">Selamat datang kembali!</p>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- KODE BARU UNTUK BUKA/TUTUP SIDEBAR ---
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');

            // Fungsi untuk membuka sidebar
            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            // Fungsi untuk menutup sidebar
            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            // Event listener untuk tombol toggle
            toggleButton.addEventListener('click', function(e) {
                e.stopPropagation(); // Mencegah event 'click' menyebar ke window
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // Event listener untuk overlay (menutup sidebar saat diklik)
            overlay.addEventListener('click', closeSidebar);


            // --- KODE LAMA ANDA UNTUK DROPDOWN MENU (TETAP DI SINI) ---
            const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();

                    const dropdown = this.parentElement.querySelector('.dropdown-menu');
                    const icon = this.querySelector('.dropdown-icon');

                    const isActive = dropdown.classList.contains('show');

                    // Tutup semua dropdown lain terlebih dahulu
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.remove('show');
                            const otherIcon = menu.parentElement.querySelector(
                                '.dropdown-icon');
                            if (otherIcon) otherIcon.classList.remove('rotate');
                        }
                    });

                    // Toggle dropdown yang diklik
                    dropdown.classList.toggle('show');
                    if (icon) icon.classList.toggle('rotate');
                });
            });

            // Menutup dropdown jika klik di luar area dropdown
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
