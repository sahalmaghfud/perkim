<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') SIPanda</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')

    <style>
        /* NEW: Keyframes animation for the background */
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

        /* UPDATED: Menerapkan animasi ke #background-slider */
        #background-slider {
            background-size: cover;
            background-position: center;
            animation: slideBackground 14s linear infinite;
            filter: grayscale(50%) brightness(80%);
        }

        /* Sidebar transition */
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Styles for the collapsed sidebar state */
        .sidebar-collapsed #sidebar {
            width: 80px;
        }

        .sidebar-collapsed .main-content {
            margin-left: 80px;
        }

        .sidebar-collapsed .sidebar-header h2,
        .sidebar-collapsed .sidebar-header p,
        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .dropdown-icon {
            display: none;
        }

        .sidebar-collapsed .sidebar-header {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
            height: 100px;
            overflow: hidden;
        }

        .sidebar-collapsed .sidebar-header img {
            margin-bottom: 0;
        }

        .sidebar-collapsed nav a {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-collapsed nav a i {
            margin-right: 0;
        }

        .sidebar-collapsed .dropdown-menu {
            display: none !important;
        }

        /* User profile dropdown animation */
        #user-dropdown-menu.show {
            max-height: 500px;
            opacity: 1;
            visibility: visible;
        }

        #user-dropdown-icon.rotate {
            transform: rotate(180deg);
        }

        /* Sidebar navigation dropdown animation */
        .dropdown-menu.show,
        .sub-dropdown-menu.show {
            max-height: 500px;
        }

        .dropdown-icon.rotate,
        .sub-dropdown-icon.rotate {
            transform: rotate(180deg);
        }
    </style>

</head>

<body class="bg-gray-50 font-sans">

    <div id="background-slider" class="fixed inset-0 z-[-1] bg-gray-100"
        style="--bg-image1: url('{{ asset('asset/image1.png') }}'); --bg-image2: url('{{ asset('asset/image2.png') }}');">
        <div class="absolute inset-0 bg-white/60"></div>
    </div>

    <div id="app-container" class="relative min-h-screen">

        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-20 md:hidden hidden"></div>
        <aside id="sidebar"
            class="bg-white text-gray-800 w-72 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto z-30 border-r border-gray-200">

            <div class="p-5 text-center border-b border-gray-200 sidebar-header">
                <img src="{{ asset('asset/logo_pkp.png') }}" alt="Logo PKP" class="h-16 w-auto mx-auto mb-4">
                <h2 class="text-xl text-teal-900 text-bold mt-2 nav-text"><strong>SIPANDA</strong></h2>
                <p class="text-sm text-gray-500 nav-text"><strong>Sistem Manajemen Surat & Dokumen</strong></p>
                <div class="mt-4 font-semibold text-base text-gray-700">
                    <span class="nav-text">{{ Auth::user()->name }}</span>
                </div>
            </div>

            <nav class="py-5">
                <a href="/dashboard" class="flex items-center py-3 px-5 border-l-4 transition-all duration-300 ">
                    <i class="fas fa-home w-6 mr-3 text-center"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-building w-6 mr-3 text-center"></i>
                            <span class="nav-text">Perumahan</span>
                        </span>
                        <i
                            class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300 nav-text"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-gray-50 transition-all duration-300 ease-in-out">
                        <a href="{{ route('dokumen.bidang', 'perumahan') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/siteplans"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-home w-4 mr-2"></i> Site Plan
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-city w-6 mr-3 text-center"></i>
                            <span class="nav-text">Permukiman</span>
                        </span>
                        <i
                            class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300 nav-text"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-gray-50 transition-all duration-300 ease-in-out">
                        <a href="{{ route('dokumen.bidang', 'permukiman') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/rtlh"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-house-damage w-4 mr-2"></i> RTLH
                        </a>

                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-road w-6 mr-3 text-center"></i>
                            <span class="nav-text">PSU</span>
                        </span>
                        <i
                            class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300 nav-text"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-gray-50 transition-all duration-300 ease-in-out">
                        <a href="{{ route('dokumen.bidang', 'psu') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/jalan_lingkungan"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-road w-4 mr-2"></i> Proyek Jalan
                        </a>

                    </div>
                </div>

                <div class="relative">
                    <a href="#"
                        class="flex items-center justify-between py-3 px-5 border-l-4 border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-300"
                        data-toggle="dropdown">
                        <span class="flex items-center">
                            <i class="fas fa-clipboard-list w-6 mr-3 text-center"></i>
                            <span class="nav-text">Sekretariat</span>
                        </span>
                        <i
                            class="fas fa-chevron-down dropdown-icon text-xs transition-transform duration-300 nav-text"></i>
                    </a>
                    <div
                        class="dropdown-menu max-h-0 overflow-hidden bg-gray-50 transition-all duration-300 ease-in-out">
                        <a href="{{ route('dokumen.bidang', 'sekertariat') }}"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-file-alt w-4 mr-2"></i> Dokumen
                        </a>
                        <a href="/pegawai"
                            class="flex items-center py-2.5 px-5 pl-12 text-sm text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-all duration-300">
                            <i class="fas fa-users w-4 mr-2"></i> Data Kepegawaian
                        </a>




                    </div>
                </div>

            </nav>
        </aside>

        <div class="flex-1 flex flex-col h-screen md:ml-72 main-content">

            <header
                class="bg-white/80 backdrop-blur-sm p-4 border-b border-gray-200 flex justify-between items-center sticky top-0 z-10 shadow-sm">
                <div class="flex items-center gap-4">
                    <button id="desktop-sidebar-toggle"
                        class="text-gray-500 hidden md:block p-2 rounded-full hover:bg-gray-100">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <button id="mobile-sidebar-toggle" class="text-gray-500 md:hidden">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">@yield('header-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-500 mt-1 hidden sm:block">Selamat datang kembali,
                            {{ explode(' ', Auth::user()->name)[0] }}!</p>
                    </div>
                </div>

                <div class="relative">
                    <button id="user-dropdown-toggle"
                        class="flex items-center gap-3 p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <div
                            class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}</div>
                        <div class="text-left hidden md:block">
                            <div class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform duration-200 hidden md:block"
                            id="user-dropdown-icon"></i>
                    </button>

                    <div id="user-dropdown-menu"
                        class="user-dropdown absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50 max-h-0 overflow-hidden opacity-0 invisible transition-all duration-300 ease-in-out">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="/change-password"
                            class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                            <i class="fas fa-cog w-4 mr-3 text-gray-400"></i> Ganti Password
                        </a>
                        <hr class="my-1 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                <i class="fas fa-sign-out-alt w-4 mr-3 text-red-500"></i> Logout
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appContainer = document.getElementById('app-container');
            const sidebar = document.getElementById('sidebar');
            const mobileToggleButton = document.getElementById('mobile-sidebar-toggle');
            const desktopToggleButton = document.getElementById('desktop-sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');
            const backgroundSlider = document.getElementById('background-slider');

            const openMobileSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };
            const closeMobileSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            mobileToggleButton.addEventListener('click', (e) => {
                e.stopPropagation();
                if (sidebar.classList.contains('-translate-x-full')) openMobileSidebar();
                else closeMobileSidebar();
            });
            overlay.addEventListener('click', closeMobileSidebar);
            desktopToggleButton.addEventListener('click', () => appContainer.classList.toggle('sidebar-collapsed'));

            const userDropdownToggle = document.getElementById('user-dropdown-toggle');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');
            const userDropdownIcon = document.getElementById('user-dropdown-icon');

            userDropdownToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
                if (userDropdownIcon) userDropdownIcon.classList.toggle('rotate');
            });

            const setupDropdown = (toggleAttr, menuClass, iconClass) => {
                document.querySelectorAll(`[data-toggle="${toggleAttr}"]`).forEach(toggle => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        if (appContainer.classList.contains('sidebar-collapsed') && window
                            .innerWidth >= 768) return;
                        const menu = toggle.nextElementSibling;
                        const icon = toggle.querySelector(`.${iconClass}`);
                        if (!menu.classList.contains('show')) {
                            document.querySelectorAll(`.${menuClass}.show`).forEach(
                                openMenu => {
                                    if (openMenu !== menu) {
                                        openMenu.classList.remove('show');
                                        const otherIcon = openMenu.previousElementSibling
                                            .querySelector(`.${iconClass}`);
                                        if (otherIcon) otherIcon.classList.remove('rotate');
                                    }
                                });
                        }
                        menu.classList.toggle('show');
                        if (icon) icon.classList.toggle('rotate');
                    });
                });
            };

            setupDropdown('dropdown', 'dropdown-menu', 'dropdown-icon');
            setupDropdown('sub-dropdown', 'sub-dropdown-menu', 'sub-dropdown-icon');

            window.addEventListener('click', (e) => {
                if (!userDropdownToggle.parentElement.contains(e.target)) {
                    userDropdownMenu.classList.remove('show');
                    if (userDropdownIcon) userDropdownIcon.classList.remove('rotate');
                }
                if (!sidebar.contains(e.target)) {
                    document.querySelectorAll('.dropdown-menu.show, .sub-dropdown-menu.show').forEach(
                        menu => menu.classList.remove('show'));
                    document.querySelectorAll('.dropdown-icon.rotate, .sub-dropdown-icon.rotate').forEach(
                        icon => icon.classList.remove('rotate'));
                }
            });
        });
    </script>

</body>

</html>

</html>
