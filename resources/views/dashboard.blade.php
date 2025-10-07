@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-md p-6 mb-8 overflow-hidden">
            <div class="relative z-0 flex flex-col sm:flex-row justify-between items-center">
                <h3 class="text-2xl font-bold tracking-wide mb-4 sm:mb-0">Dashboard</h3>

                <div class="flex items-center gap-3">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a href="{{ url('backup') }}"
                            class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg transition-all duration-200 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <i class="fas fa-database mr-2"></i> Backup
                        </a>
                    @endif

                    <div
                        class="flex items-center bg-white text-gray-700 font-medium py-2 px-4 rounded-lg border border-gray-200">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>


        <!-- Header -->


        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-600">
                <p class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Total Pegawai</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_pegawai']) }}</p>
                    <i class="fas fa-users text-3xl text-gray-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-600">
                <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wide mb-1">Jumlah Dokumen</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_dokumen']) }}</p>
                    <i class="fas fa-file-alt text-3xl text-gray-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-600">
                <p class="text-xs font-semibold text-cyan-700 uppercase tracking-wide mb-1">Jumlah CV</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_cv']) }}</p>
                    <i class="fas fa-handshake text-3xl text-gray-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-700">
                <p class="text-xs font-semibold text-green-800 uppercase tracking-wide mb-1">RTLH</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_rtlh']) }}</p>
                    <i class="fas fa-home text-3xl text-gray-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
                <p class="text-xs font-semibold text-teal-600 uppercase tracking-wide mb-1">Proyek Jalan</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_jalan']) }}</p>
                    <i class="fas fa-road text-3xl text-gray-300"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-700">
                <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide mb-1">Jumlah Siteplan</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($overview['total_siteplan']) }}</p>
                    <i class="fas fa-map text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Analisis Internal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-teal-700">Distribusi Pegawai per Bidang</h6>
                </div>
                <div class="p-6">
                    <canvas id="pegawaiChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-cyan-700">Dokumen per Bidang</h6>
                </div>
                <div class="p-6">
                    <canvas id="dokumenBidangChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Analisis RTLH -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-green-800">Status RTLH</h6>
                </div>
                <div class="p-6">
                    <canvas id="rtlhStatusChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-green-800">RTLH per Kecamatan</h6>
                </div>
                <div class="p-6">
                    <canvas id="rtlhKecamatanChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Analisis Siteplan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-emerald-800">Siteplan per Kecamatan</h6>
                </div>
                <div class="p-6">
                    <canvas id="siteplanKecamatanChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-emerald-800">Siteplan Terbaru</h6>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama PT</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Siteplan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($siteplanTerbaru as $siteplan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($siteplan->nama_pt, 20) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($siteplan->nama, 25) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $siteplan->kecamatan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">Belum ada siteplan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-cyan-700">Dokumen Terbaru</h6>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bidang</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($dokumenTerbaru as $dokumen)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($dokumen->judul, 30) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $dokumen->bidang->nama_bidang ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank"
                                                title="Lihat"
                                                class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">Belum ada dokumen
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-teal-600">Kontrak Jalan Terbaru</h6>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        CV</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. Kontrak</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kontrakTerbaru as $kontrak)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $kontrak->cv->nama_cv ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $kontrak->nomor_kontrak ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-semibold">Rp
                                            {{ number_format($kontrak->nilai_kontrak, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">Belum ada kontrak
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            // Chart Colors
            const colors = {
                primary: '#0d9488', // teal-600
                success: '#059669', // emerald-600
                info: '#0891b2', // cyan-600
                warning: '#f59e0b', // amber-500
                danger: '#dc2626', // red-600
                dark: '#065f46', // emerald-800
                light: '#64748b', // slate-500
                teal_light: '#5eead4',
                green_light: '#86efac'
            };

            // 1. Pegawai per Bidang (Pie Chart)
            const pegawaiCtx = document.getElementById('pegawaiChart').getContext('2d');
            new Chart(pegawaiCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($pegawaiPerBidang->pluck('nama_bidang')) !!},
                    datasets: [{
                        data: {!! json_encode($pegawaiPerBidang->pluck('jumlah_pegawai')) !!},
                        backgroundColor: [colors.primary, colors.success, colors.info, colors.warning, colors
                            .danger, colors.light
                        ],
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

            // 2. Dokumen per Bidang (Bar Chart)
            const dokumenBidangCtx = document.getElementById('dokumenBidangChart').getContext('2d');
            new Chart(dokumenBidangCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($dokumenPerBidang->pluck('nama_bidang')) !!},
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: {!! json_encode($dokumenPerBidang->pluck('total')) !!},
                        backgroundColor: colors.info,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 3. RTLH Status (Doughnut Chart)
            const rtlhStatusCtx = document.getElementById('rtlhStatusChart').getContext('2d');
            new Chart(rtlhStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($rtlhStatus->pluck('status')) !!},
                    datasets: [{
                        data: {!! json_encode($rtlhStatus->pluck('jumlah')) !!},
                        backgroundColor: [colors.danger, colors.success, colors.warning],
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

            // 4. RTLH per Kecamatan (Bar Chart)
            const rtlhKecamatanCtx = document.getElementById('rtlhKecamatanChart').getContext('2d');
            new Chart(rtlhKecamatanCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($rtlhPerKecamatan->pluck('kecamatan')) !!},
                    datasets: [{
                        label: 'Jumlah RTLH',
                        data: {!! json_encode($rtlhPerKecamatan->pluck('total')) !!},
                        backgroundColor: colors.green_light,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 5. Siteplan per Kecamatan
            const siteplanKecamatanCtx = document.getElementById('siteplanKecamatanChart').getContext('2d');
            new Chart(siteplanKecamatanCtx, {
                type: 'pie', // Diubah dari 'bar' menjadi 'pie'
                data: {
                    labels: {!! json_encode($siteplanPerKecamatan->pluck('kecamatan')) !!},
                    datasets: [{
                        label: 'Jumlah Siteplan',
                        data: {!! json_encode($siteplanPerKecamatan->pluck('total')) !!},
                        backgroundColor: [ // Menambahkan palet warna untuk pie chart
                            colors.dark,
                            colors.primary,
                            colors.success,
                            colors.info,
                            colors.light,
                            colors.teal_light,
                            colors.green_light
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom', // Menampilkan legenda di bawah
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
