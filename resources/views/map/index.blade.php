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

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
        }

        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>

<body class="antialiased p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <a href="#" onclick="event.preventDefault(); window.history.back();"
            class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-center text-slate-700">Peta Sebaran RTLH Kabupaten Muaro Jambi</h1>

            <div class="max-w-5xl mx-auto bg-white p-4 rounded-2xl shadow-xl border">
                <div id="map" class="rounded-lg z-10"></div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto mt-8">
            <h2 class="text-xl font-semibold mb-4 text-slate-700">Rekapitulasi Jumlah RTLH per Wilayah</h2>
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

        // Ikon default untuk semua marker
        const defaultIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Ambil data dari Laravel
        const locations = @json($locations);

        // Tambahkan marker ke peta
        if (Array.isArray(locations)) {
            locations.forEach(location => {
                if (location.koordinat) {
                    const coordinates = location.koordinat.split(',').map(coord => parseFloat(coord.trim()));
                    if (coordinates.length === 2 && !isNaN(coordinates[0]) && !isNaN(coordinates[1])) {
                        const [latitude, longitude] = coordinates;

                        // Konten untuk popup, disesuaikan dengan data baru
                        const popupContent = `
                            <div style="font-family: sans-serif; line-height: 1.5;">
                                <b style="font-size: 1.1em;">${location.nama_kepala_ruta}</b><hr style="margin: 4px 0;">
                                <b>Alamat:</b> ${location.alamat || 'N/A'}<br>
                                <b>Desa:</b> ${location.desa_kelurahan || 'N/A'}<br>
                                <b>Kepemilikan:</b> ${location.kepemilikan_tanah || 'N/A'}
                            </div>
                        `;

                        L.marker([latitude, longitude], {
                                icon: defaultIcon // Selalu gunakan ikon default
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

                    // Sembunyikan semua baris desa dan reset panah
                    document.querySelectorAll('.desa-row').forEach(row => row.classList.add(
                        'hidden'));
                    document.querySelectorAll('.kecamatan-arrow').forEach(arrow => arrow.classList
                        .remove('rotate-180'));

                    // Jika yang diklik belum aktif, buka
                    if (!isAlreadyOpen) {
                        const desaRowsToShow = document.querySelectorAll(
                            `.desa-row[data-kecamatan="${targetKecamatanName}"]`);
                        desaRowsToShow.forEach(row => row.classList.remove('hidden'));
                        this.querySelector('.kecamatan-arrow').classList.add('rotate-180');
                        activeKecamatan = targetKecamatanName;
                    } else {
                        // Jika sudah aktif, tutup (reset)
                        activeKecamatan = null;
                    }
                });
            });
        });
    </script>
</body>

</html>
