<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') SIPanda</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* CSS untuk background slider */
        #background-slider::before,
        #background-slider::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            will-change: opacity;
        }

        #background-slider::before {
            background-image: var(--bg-image1);
            animation: fade 20s infinite;
        }

        #background-slider::after {
            background-image: var(--bg-image2);
            animation: fade 20s infinite;
            animation-delay: 10s;
        }

        @keyframes fade {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            40% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 0;
            }
        }

        /* Kelas-kelas JavaScript dari kode asli */
        .dropdown-menu.show,
        .sub-dropdown-menu.show {
            max-height: 500px;
        }

        .dropdown-icon.rotate,
        .sub-dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        .user-dropdown.show {
            max-height: 200px;
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">

    <div id="background-slider" class="fixed inset-0 z-[-1] bg-black"
        style="--bg-image1: url('{{ asset('asset/image1.png') }}'); --bg-g-image2: url('{{ asset('asset/image2.png') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>


    <div class="relative min-h-screen md:flex">

        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-20 md:hidden hidden"></div>

        <aside id="sidebar"
            class="bg-gradient-to-br from-slate-800 to-slate-900 text-white w-72 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto z-30">

            <div class="p-5 text-center border-b border-white/10">
                <img src="{{ asset('asset/logo_pkp.png') }}" alt="Logo PKP" class="h-16 w-auto mx-auto mb-4">
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

                {{-- Dropdown Sekretariat --}}
                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent hover:bg-white/10 hover:border-l-white hover:translate-x-1 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-clipboard-list w-5 mr-3"></i>
                            Sekretariat
                        </span>
                        <i class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-white/5 transition-all duration-300 ease-in-out">
                        <a href="{{ route('dokumen.bidang', 'sekertariat') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/pegawai"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white hover:translate-x-1 transition-all duration-300">
                            <i class="fas fa-users w-4 mr-2"></i> Data Kepegawaian
                        </a>
                        <div class="relative">
                            <a href="#" data-toggle="sub-dropdown"
                                class="flex items-center justify-between py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white transition-all duration-300">
                                <span class="flex items-center">
                                    <i class="fas fa-folder-open w-4 mr-2"></i> Umum
                                </span>
                                <i
                                    class="fas fa-chevron-down sub-dropdown-icon text-xs transition-transform duration-300"></i>
                            </a>
                            <div
                                class="sub-dropdown-menu max-h-0 overflow-hidden bg-white/10 transition-all duration-300 ease-in-out">
                                <a href="/sekertariat/dokumen?search=&kategori=Surat+Masuk&bidang_id=4"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Surat
                                    Masuk</a>
                                <a href="/sekertariat/dokumen?search=&kategori=Surat+Keluar&bidang_id=1"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Surat
                                    Keluar</a>
                                <a href="/sekertariat/dokumen?search=&kategori=Peraturan&bidang_id=1"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Peraturan</a>
                                <a href="/sekertariat/dokumen?search=&kategori=Aset&bidang_id=1"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Aset</a>
                                <a href="/sekertariat/dokumen?search=&kategori=DPA%2FRKA%2FDPPA%2FRPKA&bidang_id=1"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">DPA/RKA/DPPA/RPKA</a>
                            </div>
                        </div>
                        <div class="relative">
                            <a href="#" data-toggle="sub-dropdown"
                                class="flex items-center justify-between py-2.5 px-5 pl-12 text-sm text-white/90 hover:bg-white/10 hover:text-white transition-all duration-300">
                                <span class="flex items-center">
                                    <i class="fas fa-coins w-4 mr-2"></i> Keuangan
                                </span>
                                <i
                                    class="fas fa-chevron-down sub-dropdown-icon text-xs transition-transform duration-300"></i>
                            </a>
                            <div
                                class="sub-dropdown-menu max-h-0 overflow-hidden bg-white/10 transition-all duration-300 ease-in-out">
                                <a href="/sekertariat/dokumen?search=&kategori=Register+SP2D&bidang_id=4"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Register
                                    SP2D</a>
                                <a href="/sekertariat/laporan?search=&kategori=BKU&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">BKU</a>
                                <a href="/sekertariat/laporan?search=&kategori=Kas+Tunai&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Kas Tunai</a>
                                <a href="/sekertariat/laporan?search=&kategori=Simpanan+Bank&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Simpanan
                                    Bank</a>
                                <a href="/sekertariat/laporan?search=&kategori=Pajak&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Pajak</a>
                                <a href="/sekertariat/laporan?search=&kategori=Fungsional&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Fungsional</a>
                                <a href="/sekertariat/laporan?search=&kategori=LRA&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">LRA</a>
                                <a href="/sekertariat/laporan?search=&kategori=Penutupan+Kas&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Penutupan
                                    Kas</a>
                                <a href="/sekertariat/laporan?search=&kategori=LPPK&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">LPPK</a>
                                <a href="/sekertariat/laporan?search=&kategori=Laporan+Keuangan&bidang_id=2"
                                    class="block py-2 px-5 pl-16 text-sm text-white/90 hover:bg-white/20">Laporan
                                    Keuangan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col h-screen">

            <header class="bg-slate-900 p-4 border-b border-slate-700 flex justify-between items-center z-10">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="text-slate-300 md:hidden">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-white">@yield('header-title', 'Dashboard')</h1>
                        <p class="text-sm text-slate-400 mt-1 hidden sm:block">Selamat datang kembali,
                            {{ explode(' ', Auth::user()->name)[0] }}!</p>
                    </div>
                </div>

                {{-- User Profile Dropdown --}}
                <div class="relative">
                    <button id="user-dropdown-toggle"
                        class="flex items-center gap-3 p-1.5 rounded-full hover:bg-slate-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

                        {{-- Avatar dengan Inisial Nama --}}
                        <div
                            class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>

                        <div class="text-left hidden md:block">
                            <div class="font-semibold text-sm text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-400">{{ Auth::user()->email ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200 hidden md:block"
                            id="user-dropdown-icon"></i>
                    </button>

                    {{-- Dropdown Menu (warnanya sudah sesuai untuk dropdown terang) --}}
                    <div id="user-dropdown-menu"
                        class="user-dropdown absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50 max-h-0 overflow-hidden opacity-0 invisible transition-all duration-200 ease-in-out">
                        <div class="px-4 py-3 border-b border-slate-200">
                            <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="#"
                            class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                            <i class="fas fa-user w-4 mr-3 text-slate-400"></i>
                            Profile
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                            <i class="fas fa-cog w-4 mr-3 text-slate-400"></i>
                            Settings
                        </a>
                        <hr class="my-1 border-slate-200">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                <i class="fas fa-sign-out-alt w-4 mr-3 text-red-500"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-5 md:p-8">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')

    {{-- KODE JAVASCRIPT TIDAK ADA PERUBAHAN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            toggleButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            const userDropdownToggle = document.getElementById('user-dropdown-toggle');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');
            const userDropdownIcon = document.getElementById('user-dropdown-icon');

            userDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
                if (userDropdownIcon) {
                    userDropdownIcon.classList.toggle('rotate');
                }
            });

            const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdown = this.nextElementSibling;
                    const icon = this.querySelector('.dropdown-icon');

                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.remove('show');
                            const otherIcon = menu.previousElementSibling.querySelector(
                                '.dropdown-icon');
                            if (otherIcon) otherIcon.classList.remove('rotate');
                        }
                    });

                    document.querySelectorAll('.sub-dropdown-menu.show').forEach(subMenu => {
                        subMenu.classList.remove('show');
                        const otherIcon = subMenu.previousElementSibling.querySelector(
                            '.sub-dropdown-icon');
                        if (otherIcon) otherIcon.classList.remove('rotate');
                    });

                    dropdown.classList.toggle('show');
                    if (icon) icon.classList.toggle('rotate');
                });
            });

            const subDropdownToggles = document.querySelectorAll('[data-toggle="sub-dropdown"]');

            subDropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const subDropdown = this.nextElementSibling;
                    const icon = this.querySelector('.sub-dropdown-icon');

                    subDropdown.classList.toggle('show');
                    if (icon) icon.classList.toggle('rotate');
                });
            });

            window.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !e.target.closest('[data-toggle="dropdown"]') && !e
                    .target.closest('[data-toggle="sub-dropdown"]')) {
                    document.querySelectorAll('.dropdown-menu, .sub-dropdown-menu').forEach(menu => menu
                        .classList.remove('show'));
                    document.querySelectorAll('.dropdown-icon, .sub-dropdown-icon').forEach(ico => ico
                        .classList.remove('rotate'));
                }

                const userDropdownContainer = userDropdownToggle.parentElement;
                if (!userDropdownContainer.contains(e.target) && userDropdownMenu.classList.contains(
                        'show')) {
                    userDropdownMenu.classList.remove('show');
                    if (userDropdownIcon) {
                        userDropdownIcon.classList.remove('rotate');
                    }
                }
            });
        });
    </script>
</body>

</html>
