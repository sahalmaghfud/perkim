<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sebaran Rumah Tidak Layak Huni</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        body {
            background-color: #f8fafc;
        }

        #map {
            height: 500px;
            width: 100%;
        }

        .legend {
            background: white;
            padding: 10px;
            line-height: 1.5;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .legend i {
            width: 18px;
            height: 28px;
            display: inline-block;
            background-size: contain;
            background-repeat: no-repeat;
            vertical-align: middle;
            margin-right: 8px;
        }
    </style>
</head>

<body class="antialiased">
    <a href="#" onclick="event.preventDefault(); window.history.back();"
        class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center text-slate-700">Peta Sebaran RTLH Kabupaten Muaro Jambi</h1>

        <div class="max-w-5xl mx-auto bg-white p-4 rounded-2xl shadow-xl border">
            <div id="map" class="rounded-lg z-10"></div>
        </div>

        <!-- Legenda Warna -->
        <div class="max-w-5xl mx-auto mt-4">
            <div class="legend">
                <h3 class="font-semibold mb-2 text-slate-700">Keterangan Warna Pin:</h3>
                <div><i
                        style="background-image:url('https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png')"></i>
                    Belum diperbaiki</div>
                <div><i
                        style="background-image:url('https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png')"></i>
                    Sedang diperbaiki</div>
                <div><i
                        style="background-image:url('https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png')"></i>
                    Sudah diperbaiki</div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto mt-8">
        <h2 class="text-xl font-semibold mb-4 text-slate-700">Rekapitulasi Jumlah RTLH</h2>
        <div class="bg-white rounded-2xl shadow-xl border overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wilayah
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($rekapitulasi as $kecamatan)
                        <tr class="bg-gray-100 hover:bg-gray-200 cursor-pointer kecamatan-toggle"
                            data-target-kecamatan="{{ $kecamatan['nama_kecamatan'] }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                <div class="flex items-center justify-between">
                                    <span>KECAMATAN {{ strtoupper($kecamatan['nama_kecamatan']) }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 transition-transform kecamatan-arrow" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                {{ $kecamatan['total'] }}
                            </td>
                        </tr>

                        @foreach ($kecamatan['desa'] as $desa)
                            <tr class="desa-row hidden" data-kecamatan="{{ $kecamatan['nama_kecamatan'] }}">
                                <td class="pl-12 pr-6 py-3 whitespace-nowrap text-sm text-gray-700">
                                    - {{ $desa['nama'] }}
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">
                                    {{ $desa['jumlah'] }}
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                Data rekapitulasi tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-1.55, 103.82], 10);

        // Tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Ikon kustom berdasarkan status
        const icons = {
            'sudah diperbaiki': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            'belum diperbaiki': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            'sedang diperbaiki': L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            'default': L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        };

        // Ambil data dari Laravel
        const locations = @json($locations);

        // Tambahkan marker sesuai status
        if (Array.isArray(locations)) {
            locations.forEach(location => {
                if (location.koordinat) {
                    const coordinates = location.koordinat.split(',').map(coord => parseFloat(coord.trim()));
                    if (coordinates.length === 2 && !isNaN(coordinates[0]) && !isNaN(coordinates[1])) {
                        const [latitude, longitude] = coordinates;
                        const status = (location.status || '').toLowerCase();

                        const icon = icons[status] || icons['default'];

                        const popupContent = `
                            <div style="font-family: sans-serif; line-height: 1.5;">
                                <b style="font-size: 1.1em;">${location.nama_kepala_ruta}</b><hr style="margin: 4px 0;">
                                <b>Alamat:</b> ${location.alamat}<br>
                                <b>Kategori:</b> ${location.kategori_rumah}<br>
                                <b>Status:</b> ${location.status}
                            </div>
                        `;

                        L.marker([latitude, longitude], {
                                icon
                            })
                            .addTo(map)
                            .bindPopup(popupContent);
                    }
                }
            });
        }

        // Toggle untuk rekapitulasi
        document.addEventListener('DOMContentLoaded', function() {
            let activeKecamatan = null;
            const kecamatanToggles = document.querySelectorAll('.kecamatan-toggle');

            kecamatanToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetKecamatanName = this.dataset.targetKecamatan;
                    const isAlreadyOpen = activeKecamatan === targetKecamatanName;

                    document.querySelectorAll('.desa-row').forEach(row => row.classList.add(
                        'hidden'));
                    document.querySelectorAll('.kecamatan-arrow').forEach(arrow => arrow.classList
                        .remove('rotate-180'));

                    if (!isAlreadyOpen) {
                        const desaRowsToShow = document.querySelectorAll(
                            `.desa-row[data-kecamatan="${targetKecamatanName}"]`);
                        desaRowsToShow.forEach(row => row.classList.remove('hidden'));
                        this.querySelector('.kecamatan-arrow').classList.add('rotate-180');
                        activeKecamatan = targetKecamatanName;
                    } else {
                        activeKecamatan = null;
                    }
                });
            });
        });
    </script>
</body>

</html>
