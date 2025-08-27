{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') di layout --}}
@section('title', 'Dashboard')

@section('header-title', 'Dashboard Manajemen Dokumen')

{{-- Mengisi @yield('content') di layout --}}
@section('content')

    {{-- Notifikasi Sukses (Contoh, bisa dihapus jika tidak perlu) --}}
    <div id="success-alert"
        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex justify-between items-center shadow-sm"
        role="alert">
        <p class="font-medium">Dokumen baru berhasil ditambahkan!</p>
        <button type="button" onclick="document.getElementById('success-alert').style.display='none'" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- Bagian 1: Kartu Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        {{-- Total Dokumen --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-blue-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <i class="fas fa-file-alt fa-lg"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Dokumen</h3>
                <p class="text-2xl font-bold text-gray-800">218</p>
            </div>
        </div>
        {{-- Dokumen Masuk --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-green-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <i class="fas fa-file-download fa-lg"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Dokumen Masuk</h3>
                <p class="text-2xl font-bold text-gray-800">142</p>
            </div>
        </div>
        {{-- Dokumen Keluar --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-yellow-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <i class="fas fa-file-upload fa-lg"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Dokumen Keluar</h3>
                <p class="text-2xl font-bold text-gray-800">76</p>
            </div>
        </div>
        {{-- Dokumen Bulan Ini --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-purple-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Dokumen Bulan Ini</h3>
                <p class="text-2xl font-bold text-gray-800">25</p>
            </div>
        </div>
    </div>

    {{-- Bagian 2: Visualisasi Data (Grafik) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Grafik Jenis Dokumen --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Jenis Dokumen</h3>
            <div class="h-64">
                <canvas id="jenisDokumenChart"></canvas>
            </div>
        </div>

        {{-- Grafik Dokumen per Divisi --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Dokumen per Divisi</h3>
            <div class="h-64">
                <canvas id="dokumenPerDivisiChart"></canvas>
            </div>
        </div>
    </div>


    {{-- Bagian 3: Tabel Aktivitas Dokumen Terbaru --}}
    <div class="bg-white rounded-lg shadow-md">

        {{-- Header dengan judul dan tombol tambah --}}
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Dokumen Terbaru</h3>
            <a href="#"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                <i class="fas fa-plus"></i>
                <span>Tambah Dokumen</span>
            </a>
        </div>

        {{-- Kontainer tabel agar responsif --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor
                            Dokumen</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perihal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Divisi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- DATA DUMMY 1 --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">SOP/HRD/2025/08-01</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">SOP Proses Rekrutmen Baru</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">27 Agu 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2.5 py-1 inline-block text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Dokumen Keluar
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Sumber Daya Manusia</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                            <a href="#" target="_blank" title="Lihat"
                                class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm"><i
                                    class="fas fa-eye"></i></a>
                            <a href="#" title="Edit"
                                class="bg-amber-500 hover:bg-amber-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm"><i
                                    class="fas fa-pencil-alt"></i></a>
                            <form action="#" method="POST" class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                <button type="submit" title="Hapus"
                                    class="bg-red-600 hover:bg-red-700 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    {{-- DATA DUMMY 2 --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">QUO/VENDOR-XYZ/2025/234
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Quotation Harga Server</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">26 Agu 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2.5 py-1 inline-block text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Dokumen Masuk
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Teknologi Informasi</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                            <a href="#" target="_blank" title="Lihat"
                                class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm"><i
                                    class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    {{-- DATA DUMMY 3 --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">REPORT/FIN/Q3-2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Laporan Keuangan Kuartal 3</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">25 Agu 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2.5 py-1 inline-block text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Dokumen Keluar
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Keuangan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                            <a href="#" target="_blank" title="Lihat"
                                class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm"><i
                                    class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer untuk melihat semua data --}}
        <div class="p-5 border-t border-gray-200 text-center">
            <a href="#" class="text-blue-600 hover:underline font-semibold">
                Lihat Semua Dokumen &rarr;
            </a>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Memuat pustaka Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Skrip untuk menghilangkan notifikasi sukses secara otomatis
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }, 5000);
            }

            // --- Skrip untuk Grafik dengan Data Dummy ---

            // 1. Grafik Jenis Dokumen (Pie Chart)
            const jenisDokumenCtx = document.getElementById('jenisDokumenChart').getContext('2d');
            const jenisDokumenData = {
                'Dokumen Masuk': 172,
                'Dokumen Keluar': 76
            };

            new Chart(jenisDokumenCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(jenisDokumenData),
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: Object.values(jenisDokumenData),
                        backgroundColor: ['rgba(59, 130, 246, 0.7)', 'rgba(34, 197, 94, 0.7)'],
                        borderColor: ['rgba(59, 130, 246, 1)', 'rgba(34, 197, 94, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // 2. Grafik Dokumen per Divisi (Bar Chart)
            const dokumenPerDivisiCtx = document.getElementById('dokumenPerDivisiChart').getContext('2d');
            const dokumenPerDivisiData = {
                'Marketing': 45,
                'Teknologi Informasi': 60,
                'Sumber Daya Manusia': 55,
                'Keuangan': 38,
                'Operasional': 20
            };

            new Chart(dokumenPerDivisiCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(dokumenPerDivisiData),
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: Object.values(dokumenPerDivisiData),
                        backgroundColor: 'rgba(139, 92, 246, 0.7)',
                        borderColor: 'rgba(139, 92, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
