{{--
    File: resources/views/rtlh/_form.blade.php
    Description: Komponen form lengkap untuk data RTLH, termasuk semua input fields dan tombol aksi.
--}}

{{-- Menampilkan error validasi jika ada --}}
@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <div class="flex">
            <div class="py-1"><i class="fas fa-exclamation-triangle mr-3 text-red-500"></i></div>
            <div>
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

{{-- SEKSI 1: INFORMASI PENGHUNI & ALAMAT --}}
<h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-6">
    Informasi Penghuni & Alamat
</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Nama Kepala Ruta --}}
    <div>
        <label for="nama_kepala_ruta" class="block text-sm font-medium text-slate-700">Nama Kepala Ruta</label>
        <input type="text" name="nama_kepala_ruta" id="nama_kepala_ruta"
            value="{{ old('nama_kepala_ruta', $rumahTidakLayakHuni->nama_kepala_ruta ?? '') }}" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>

    {{-- NIK --}}
    <div>
        <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
        <input type="text" name="nik" id="nik" value="{{ old('nik', $rumahTidakLayakHuni->nik ?? '') }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>

    {{-- Umur --}}
    <div>
        <label for="umur" class="block text-sm font-medium text-slate-700">Umur (Tahun)</label>
        <input type="number" name="umur" id="umur" value="{{ old('umur', $rumahTidakLayakHuni->umur ?? '') }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>

    {{-- Jenis Kelamin --}}
    <div>
        <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $rumahTidakLayakHuni->jenis_kelamin ?? '') == 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $rumahTidakLayakHuni->jenis_kelamin ?? '') == 'P')>Perempuan</option>
        </select>
    </div>

    {{-- Alamat --}}
    <div class="md:col-span-2">
        <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
        <textarea name="alamat" id="alamat" rows="3" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">{{ old('alamat', $rumahTidakLayakHuni->alamat ?? '') }}</textarea>
    </div>

    {{-- Kecamatan --}}
    <div>
        <label for="kecamatan" class="block text-sm font-medium text-slate-700">Kecamatan</label>
        <select name="kecamatan" id="kecamatan" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            <option value="">Pilih Kecamatan</option>
            {{-- Opsi kecamatan akan diisi oleh JavaScript --}}
        </select>
    </div>

    {{-- Desa/Kelurahan --}}
    <div>
        <label for="desa_kelurahan" class="block text-sm font-medium text-slate-700">Desa/Kelurahan</label>
        <select name="desa_kelurahan" id="desa_kelurahan" required disabled
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm bg-slate-50 cursor-not-allowed">
            <option value="">Pilih Kecamatan Terlebih Dahulu</option>
        </select>
    </div>

    {{-- Kode Wilayah --}}
    <div>
        <label for="kode_wilayah" class="block text-sm font-medium text-slate-700">Kode Wilayah</label>
        <input type="text" name="kode_wilayah" id="kode_wilayah"
            value="{{ old('kode_wilayah', $rumahTidakLayakHuni->kode_wilayah ?? '') }}" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>
</div>

{{-- SEKSI 2: DETAIL PROPERTI & STATUS BANTUAN --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-midnight_green mb-6">
        Detail Properti & Status Bantuan
    </h3>
    <div class="p-6 border border-slate-200 rounded-lg bg-slate-50 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Luas Rumah --}}
            <div>
                <label for="luas_rumah" class="block text-sm font-medium text-slate-700">Luas Rumah (M²)</label>
                <input type="number" step="0.01" name="luas_rumah" id="luas_rumah"
                    value="{{ old('luas_rumah', $rumahTidakLayakHuni->luas_rumah ?? '') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            </div>

            {{-- Kategori Rumah --}}
            <div>
                <label for="kategori_rumah" class="block text-sm font-medium text-slate-700">Kategori Rumah</label>
                <input type="text" name="kategori_rumah" id="kategori_rumah"
                    value="{{ old('kategori_rumah', $rumahTidakLayakHuni->kategori_rumah ?? '') }}" required
                    placeholder="Contoh: Rusak Ringan, Rusak Berat"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            </div>

            {{-- Kepemilikan Rumah --}}
            <div>
                <label for="kepemilikan_rumah" class="block text-sm font-medium text-slate-700">Kepemilikan
                    Rumah</label>
                <input type="text" name="kepemilikan_rumah" id="kepemilikan_rumah"
                    value="{{ old('kepemilikan_rumah', $rumahTidakLayakHuni->kepemilikan_rumah ?? '') }}" required
                    placeholder="Contoh: Milik Sendiri, Sewa"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            </div>

            {{-- Kepemilikan Tanah --}}
            <div>
                <label for="kepemilikan_tanah" class="block text-sm font-medium text-slate-700">Kepemilikan
                    Tanah</label>
                <input type="text" name="kepemilikan_tanah" id="kepemilikan_tanah"
                    value="{{ old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') }}" required
                    placeholder="Contoh: Milik Sendiri, Tanah Desa"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            </div>

            {{-- Koordinat --}}
            <div class="md:col-span-2">
                <label for="koordinat" class="block text-sm font-medium text-slate-700">Koordinat</label>
                <input type="text" name="koordinat" id="koordinat"
                    value="{{ old('koordinat', $rumahTidakLayakHuni->koordinat ?? '') }}" required
                    placeholder="Contoh: -7.2575, 112.7521"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            </div>

            {{-- Status Bantuan --}}
            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-slate-700">Status Bantuan</label>
                <select name="status" id="status" required
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                    <option value="belum diperbaiki" @selected(old('status', $rumahTidakLayakHuni->status ?? 'belum diperbaiki') == 'belum diperbaiki')>Belum Diperbaiki</option>
                    <option value="sedang diperbaiki" @selected(old('status', $rumahTidakLayakHuni->status ?? '') == 'sedang diperbaiki')>Sedang Diperbaiki</option>
                    <option value="sudah diperbaiki" @selected(old('status', $rumahTidakLayakHuni->status ?? '') == 'sudah diperbaiki')>Sudah Diperbaiki</option>
                </select>
            </div>
        </div>

        {{-- DOKUMENTASI FOTO --}}
        <div class="mt-6 border-t border-slate-300 pt-6">
            <h4 class="text-md font-semibold text-slate-800 mb-4">Dokumentasi Foto</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Foto Sebelum Perbaikan --}}
                <div>
                    <label for="foto_sebelum_perbaikan" class="block text-sm font-medium text-slate-700">Foto Sebelum
                        Perbaikan</label>
                    <input type="file" name="foto_sebelum_perbaikan" id="foto_sebelum_perbaikan"
                        @if (!isset($rumahTidakLayakHuni)) required @endif
                        class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                    @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_sebelum_perbaikan)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sebelum_perbaikan) }}"
                                alt="Foto Sebelum" class="rounded-md border border-slate-300 h-32 w-auto">
                            <small class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>
                    @endif
                </div>

                {{-- Foto Sesudah Perbaikan --}}
                <div>
                    <label for="foto_sesudah_perbaikan" class="block text-sm font-medium text-slate-700">Foto Sesudah
                        Perbaikan</label>
                    <input type="file" name="foto_sesudah_perbaikan" id="foto_sesudah_perbaikan"
                        class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                    @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_sesudah_perbaikan)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sesudah_perbaikan) }}"
                                alt="Foto Sesudah" class="rounded-md border border-slate-300 h-32 w-auto">
                            <small class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-200 gap-4">
    <a href="{{ route('rtlh.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center justify-center px-6 py-2.5 bg-midnight_green-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-midnight_green-600">
        <i class="fas fa-save mr-2"></i>
        {{ isset($rumahTidakLayakHuni) ? 'Simpan Perubahan' : 'Simpan Data' }}
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa_kelurahan');

            // Data Kecamatan dan Desa
            const data = {
                "Bahar Selatan": ["Adipura Kencana", "Bukit Jaya", "Bukit Subur", "Mekar Jaya", "Tanjung Baru",
                    "Tanjung Lebar", "Tanjung Mulia", "Tanjung Sari", "Tri Jaya", "Ujung Tanjung"
                ],
                "Bahar Utara": ["Bahar Mulya", "Bukit Mulya", "Markanding", "Matra Manunggal", "Mulya Jaya",
                    "Pinang Tinggi", "Sumber Jaya", "Sumber Mulya", "Sungai Dayo", "Talang Bukit",
                    "Talang Datar"
                ],
                "Jambi Luar Kota": ["Danau Sarang Elang", "Kedemangan", "Maro Sebo", "Mendalo Darat",
                    "Mendalo Indah", "Mendalo Laut", "Muara Pijoan", "Muhajirin", "Pematang Gajah",
                    "Pematang Jering", "Penyengat Olak", "Rengas Bandung", "Sarang Burung", "Sembubuk",
                    "Senaung", "Simpang Limo", "Simpang Sungai Duren", "Sungai Bertam", "Sungai Duren",
                    "Pijoan"
                ],
                "Kumpeh": ["Betung", "Gedong Karya", "Jebus", "Londerang", "Maju Jaya", "Mekar Sari",
                    "Pematang Raman", "Petanang", "Puding", "Pulau Mentaro", "Rantau Panjang", "Rondang",
                    "Seponjen", "Sogo", "Sungai Aur", "Sungai Bungur", "Tanjung"
                ],
                "Kumpeh Ulu": ["Pudak", "Muara Kumpeh", "Kota Karang", "Kasang Lopak Alai", "Kasang Pudak",
                    "Solok", "Sakean", "Lopak Alai", "Tarikan", "Ramin", "Teluk Raya", "Pemunduran",
                    "Sipin Teluk Duren", "Arang Arang", "Sumber Jaya", "Sungai Terap", "Kasang Kumpeh",
                    "Kasang Kota Karang"
                ],
                "Maro Sebo": ["Bakung", "Baru", "Danau Kedap", "Danau Lamo", "Jambi Tulo", "Lubuk Raman",
                    "Muaro Jambi", "Mudung Darat", "Niaso", "Setiris", "Tanjung Katung", "Jambi Kecil"
                ],
                "Mestong": ["Baru", "Ibru", "Muaro Sebapo", "Naga Sari", "Nyogan", "Pelempang", "Pondok Meja",
                    "Sebapo", "Suka Damai", "Suka Maju", "Sungai Landai", "Tanjung Pauh KM.32",
                    "Tanjung Pauh KM.39", "Tanjung Pauh Talang Pelita", "Tempino"
                ],
                "Sekernan": ["Berembang", "Bukit Baling", "Gerunggung", "Kedotan", "Keranggan",
                    "Pematang Pulai", "Pulau Kayu Aro", "Rantau Majo", "Sekernan", "Suak Putat",
                    "Suko Awin Jaya", "Tantan", "Tanjung Lanjut", "Tunas Baru", "Tunas Mudo", "Sengeti"
                ],
                "Sungai Bahar": ["Bakti Mulya", "Berkah", "Bukit Makmur", "Bukit Mas", "Marga Manunggal Jaya",
                    "Marga Mulya", "Mekar Sari Makmur", "Panca Bakti", "Panca Mulya", "Suka Makmur",
                    "Tanjung Harapan"
                ],
                "Sungai Gelam": ["Sungai Gelam", "Gambut Jaya", "Kebon IX", "Ladang Panjang", "Mekar Jaya",
                    "Mingkung Jaya", "Parit", "Petaling Jaya", "Sido Mukti", "Sumber Agung",
                    "Talang Belido", "Talang Kerinci", "Tangkit", "Tangkit Baru", "Trimulya Jaya"
                ],
                "Taman Rajo": ["Dusun Mudo", "Kemingking Dalam", "Kemingking Luar", "Kunangan", "Manis Mato",
                    "Rukam", "Sekumbung", "Talang Duku", "Tebat Patah", "Teluk Jambu"
                ]
            };

            // Mengambil nilai lama (jika ada error validasi) atau nilai dari database
            const oldKecamatan = "{{ old('kecamatan', $rumahTidakLayakHuni->kecamatan ?? '') }}";
            const oldDesa = "{{ old('desa_kelurahan', $rumahTidakLayakHuni->desa_kelurahan ?? '') }}";

            // Mengisi dropdown kecamatan saat halaman dimuat
            for (const kecamatan in data) {
                const option = document.createElement('option');
                option.value = kecamatan;
                option.textContent = kecamatan;
                if (kecamatan === oldKecamatan) {
                    option.selected = true;
                }
                kecamatanSelect.appendChild(option);
            }

            // Fungsi untuk mengisi dropdown desa berdasarkan kecamatan yang dipilih
            function populateDesa(selectedKecamatan) {
                // Hapus semua opsi desa yang ada
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

                if (selectedKecamatan && data[selectedKecamatan]) {
                    desaSelect.disabled = false;
                    desaSelect.classList.remove('bg-slate-50', 'cursor-not-allowed');
                    const desas = data[selectedKecamatan];

                    desas.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa;
                        option.textContent = desa;
                        // Pilih desa jika cocok dengan data lama/database
                        if (desa === oldDesa) {
                            option.selected = true;
                        }
                        desaSelect.appendChild(option);
                    });
                } else {
                    // Nonaktifkan jika tidak ada kecamatan yang dipilih
                    desaSelect.disabled = true;
                    desaSelect.classList.add('bg-slate-50', 'cursor-not-allowed');
                    desaSelect.innerHTML = '<option value="">Pilih Kecamatan Terlebih Dahulu</option>';
                }
            }

            // Event listener untuk memanggil fungsi populateDesa saat kecamatan berubah
            kecamatanSelect.addEventListener('change', function() {
                // Reset oldDesa saat kecamatan berubah agar tidak memilih desa dari kecamatan sebelumnya
                const oldDesa = '';
                populateDesa(this.value);
            });

            // Panggil fungsi populateDesa saat halaman pertama kali dimuat jika sudah ada kecamatan yang terpilih
            if (oldKecamatan) {
                populateDesa(oldKecamatan);
            }
        });
    </script>
@endpush
