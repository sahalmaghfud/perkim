<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') SIPanda</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

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

        /* Custom styles for user dropdown */
        .user-dropdown.show {
            max-height: 200px;
            opacity: 1;
            visibility: visible;
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

                        <a href="{{ route('dokumen.bidang', 'perumahan') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/siteplans"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-home w-4 mr-2"></i> Site Plan
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
                        <a href="{{ route('dokumen.bidang', 'permukiman') }}"
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
                        <a href="{{ route('dokumen.bidang', 'psu') }}"
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

                        <a href="{{ route('dokumen.bidang', 'tu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/pegawai"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-users w-4 mr-2"></i> Data Kepegawaian
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

                {{-- User Profile Dropdown with Logout --}}
                <div class="relative">
                    <button id="user-dropdown-toggle"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-user-circle text-3xl text-gray-500"></i>
                        <div class="text-left">
                            <div class="font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"
                            id="user-dropdown-icon"></i>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="user-dropdown-menu"
                        class="user-dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50 max-h-0 overflow-hidden opacity-0 invisible transition-all duration-200 ease-in-out">
                        <a href="#"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                            <i class="fas fa-user w-4 mr-3 text-gray-400"></i>
                            Profile
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                            <i class="fas fa-cog w-4 mr-3 text-gray-400"></i>
                            Settings
                        </a>
                        <hr class="my-1 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                <i class="fas fa-sign-out-alt w-4 mr-3 text-red-500"></i>
                                Logout
                            </button>
                        </form>
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

            // --- USER DROPDOWN FUNCTIONALITY ---
            const userDropdownToggle = document.getElementById('user-dropdown-toggle');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');
            const userDropdownIcon = document.getElementById('user-dropdown-icon');

            userDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isActive = userDropdownMenu.classList.contains('show');

                // Close all other dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    const otherIcon = menu.parentElement.querySelector('.dropdown-icon');
                    if (otherIcon) otherIcon.classList.remove('rotate');
                });

                // Toggle user dropdown
                userDropdownMenu.classList.toggle('show');
                userDropdownIcon.classList.toggle('rotate');
            });

            // --- KODE LAMA ANDA UNTUK DROPDOWN MENU (TETAP DI SINI) ---
            const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdown = this.parentElement.querySelector('.dropdown-menu');
                    const icon = this.querySelector('.dropdown-icon');

                    const isActive = dropdown.classList.contains('show');

                    // Close user dropdown if open
                    userDropdownMenu.classList.remove('show');
                    userDropdownIcon.classList.remove('rotate');

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
                if (!e.target.closest('[data-toggle="dropdown"]') && !e.target.closest(
                        '#user-dropdown-toggle')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove(
                        'show'));
                    document.querySelectorAll('.dropdown-icon').forEach(ico => ico.classList.remove(
                        'rotate'));
                    userDropdownMenu.classList.remove('show');
                    userDropdownIcon.classList.remove('rotate');
                }
            });
        });
    </script>
</body>

</html>
