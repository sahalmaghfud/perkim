{{--
    File: resources/views/jalan_lingkungan/_form.blade.php
    Description: Komponen form lengkap untuk data Jalan Lingkungan, termasuk semua input fields dan tombol aksi.
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



{{-- SEKSI 1: DETAIL PEKERJAAN & LOKASI --}}
<h3 class="text-xl font-semibold text-slate-800 border-b border-slate-200 pb-4 mb-6">
    <i class="fas fa-road mr-2 text-slate-500"></i>
    Detail Pekerjaan & Lokasi
</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Uraian Pekerjaan --}}
    <div class="md:col-span-2">
        <label for="uraian" class="block text-sm font-medium text-slate-700">Uraian Pekerjaan</label>
        <input type="text" name="uraian" id="uraian" value="{{ old('uraian', $jalanLingkungan->uraian ?? '') }}"
            required placeholder="Contoh: Pembangunan Jalan Beton RT.01/RW.02"
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
        <label for="desa" class="block text-sm font-medium text-slate-700">Desa/Kelurahan</label>
        <select name="desa" id="desa" required disabled
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm bg-slate-50 cursor-not-allowed">
            <option value="">Pilih Kecamatan Terlebih Dahulu</option>
        </select>
    </div>

    {{-- Alamat Lengkap --}}
    <div class="md:col-span-2">
        <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap (Lokasi Pekerjaan)</label>
        <textarea name="alamat" id="alamat" rows="3"
            placeholder="Contoh: Jl. Merdeka No. 10, RT.01/RW.02, Desa Makmur, Kecamatan Maju Jaya"
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('alamat', $jalanLingkungan->alamat ?? '') }}</textarea>
    </div>

    {{-- Volume --}}
    <div>
        <label for="volume" class="block text-sm font-medium text-slate-700">Volume</label>
        <input type="number" step="0.01" name="volume" id="volume"
            value="{{ old('volume', $jalanLingkungan->volume ?? '') }}" placeholder="Contoh: 150.5"
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    {{-- Satuan --}}
    <div>
        <label for="satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
        <input type="text" name="satuan" id="satuan" value="{{ old('satuan', $jalanLingkungan->satuan ?? '') }}"
            placeholder="Contoh: m³, m²"
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

{{-- SEKSI 2: INFORMASI KEUANGAN --}}
{{-- ... (Konten Seksi 2 sampai 5 tetap sama, tidak ada perubahan) ... --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-slate-800 mb-6">
        <i class="fas fa-money-bill-wave mr-2 text-slate-500"></i>
        Informasi Keuangan
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Harga Satuan --}}
        <div>
            <label for="harga_satuan" class="block text-sm font-medium text-slate-700">Harga Satuan (Rp)</label>
            <input type="number" name="harga_satuan" id="harga_satuan"
                value="{{ old('harga_satuan', $jalanLingkungan->harga_satuan ?? '') }}" placeholder="Contoh: 750000"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        {{-- Jumlah Harga --}}
        <div>
            <label for="jumlah_harga" class="block text-sm font-medium text-slate-700">Jumlah Harga (Rp)</label>
            <input type="number" name="jumlah_harga" id="jumlah_harga"
                value="{{ old('jumlah_harga', $jalanLingkungan->jumlah_harga ?? '') }}"
                placeholder="Hasil dari Volume x Harga Satuan"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    </div>
</div>

{{-- SEKSI 3: DETAIL KONTRAK --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-slate-800 mb-6">
        <i class="fas fa-file-signature mr-2 text-slate-500"></i>
        Detail Kontrak
    </h3>
    <div class="p-6 border border-slate-200 rounded-lg bg-slate-50 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- CV Pelaksana --}}
            <div class="lg:col-span-3">
                <label for="cv_id" class="block text-sm font-medium text-slate-700">CV Pelaksana</label>
                <select name="cv_id" id="cv_id" required
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">-- Pilih CV --</option>
                    @foreach ($cvs as $cv)
                        <option value="{{ $cv->id }}" @selected(old('cv_id', $jalanLingkungan->cv_id ?? '') == $cv->id)>
                            {{ $cv->nama_cv }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nomor Kontrak --}}
            <div>
                <label for="nomor_kontrak" class="block text-sm font-medium text-slate-700">Nomor Kontrak</label>
                <input type="text" name="nomor_kontrak" id="nomor_kontrak"
                    value="{{ old('nomor_kontrak', $jalanLingkungan->nomor_kontrak ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            {{-- Tanggal Kontrak --}}
            <div>
                <label for="tanggal_kontrak" class="block text-sm font-medium text-slate-700">Tanggal Kontrak</label>
                <input type="date" name="tanggal_kontrak" id="tanggal_kontrak"
                    value="{{ old('tanggal_kontrak', isset($jalanLingkungan->tanggal_kontrak) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_kontrak)->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            {{-- Nilai Kontrak --}}
            <div>
                <label for="nilai_kontrak" class="block text-sm font-medium text-slate-700">Nilai Kontrak (Rp)</label>
                <input type="number" name="nilai_kontrak" id="nilai_kontrak"
                    value="{{ old('nilai_kontrak', $jalanLingkungan->nilai_kontrak ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            {{-- Tanggal Awal Pekerjaan --}}
            <div>
                <label for="tanggal_awal_pekerjaan" class="block text-sm font-medium text-slate-700">Tgl Awal
                    Pekerjaan</label>
                <input type="date" name="tanggal_awal_pekerjaan" id="tanggal_awal_pekerjaan"
                    value="{{ old('tanggal_awal_pekerjaan', isset($jalanLingkungan->tanggal_awal_pekerjaan) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_awal_pekerjaan)->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            {{-- Tanggal Akhir Pekerjaan --}}
            <div>
                <label for="tanggal_akhir_pekerjaan" class="block text-sm font-medium text-slate-700">Tgl Akhir
                    Pekerjaan</label>
                <input type="date" name="tanggal_akhir_pekerjaan" id="tanggal_akhir_pekerjaan"
                    value="{{ old('tanggal_akhir_pekerjaan', isset($jalanLingkungan->tanggal_akhir_pekerjaan) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_akhir_pekerjaan)->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>
    </div>
</div>

{{-- SEKSI 4: REALISASI PENCAIRAN --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-slate-800 mb-6">
        <i class="fas fa-cash-register mr-2 text-slate-500"></i>
        Realisasi Pencairan
    </h3>
    <div class="space-y-8">
        {{-- Tahap 30% --}}
        <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
            <h4 class="text-lg font-semibold text-slate-700 mb-4 border-b border-slate-200 pb-2">Tahap 30%</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Fields for 30% stage --}}
                @include('jalan_lingkungan._pencairan_fields', ['stage' => '30'])
            </div>
        </div>

        {{-- Tahap 95% --}}
        <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
            <h4 class="text-lg font-semibold text-slate-700 mb-4 border-b border-slate-200 pb-2">Tahap 95%</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Fields for 95% stage --}}
                @include('jalan_lingkungan._pencairan_fields', ['stage' => '95'])
            </div>
        </div>

        {{-- Tahap 100% --}}
        <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
            <h4 class="text-lg font-semibold text-slate-700 mb-4 border-b border-slate-200 pb-2">Tahap 100%
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Fields for 100% stage --}}
                @include('jalan_lingkungan._pencairan_fields', ['stage' => '100'])
            </div>
        </div>
    </div>
</div>

{{-- SEKSI 5: BERITA ACARA & KETERANGAN --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-slate-800 mb-6">
        <i class="fas fa-archive mr-2 text-slate-500"></i>
        Berita Acara & Keterangan
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- BAPHP --}}
        <div>
            <label for="baphp_nomor" class="block text-sm font-medium text-slate-700">Nomor BAPHP</label>
            <input type="text" name="baphp_nomor" id="baphp_nomor"
                value="{{ old('baphp_nomor', $jalanLingkungan->baphp_nomor ?? '') }}"
                class="mt-1 block w-full input-style">
        </div>
        <div>
            <label for="baphp_tanggal" class="block text-sm font-medium text-slate-700">Tanggal BAPHP</label>
            <input type="date" name="baphp_tanggal" id="baphp_tanggal"
                value="{{ old('baphp_tanggal', isset($jalanLingkungan->baphp_tanggal) ? \Carbon\Carbon::parse($jalanLingkungan->baphp_tanggal)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full input-style">
        </div>

        {{-- BAST --}}
        <div>
            <label for="bast_nomor" class="block text-sm font-medium text-slate-700">Nomor BAST</label>
            <input type="text" name="bast_nomor" id="bast_nomor"
                value="{{ old('bast_nomor', $jalanLingkungan->bast_nomor ?? '') }}"
                class="mt-1 block w-full input-style">
        </div>
        <div>
            <label for="bast_tanggal" class="block text-sm font-medium text-slate-700">Tanggal BAST</label>
            <input type="date" name="bast_tanggal" id="bast_tanggal"
                value="{{ old('bast_tanggal', isset($jalanLingkungan->bast_tanggal) ? \Carbon\Carbon::parse($jalanLingkungan->bast_tanggal)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full input-style">
        </div>

        {{-- Keterangan --}}
        <div class="md:col-span-2">
            <label for="keterangan" class="block text-sm font-medium text-slate-700">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full input-style">{{ old('keterangan', $jalanLingkungan->keterangan ?? '') }}</textarea>
        </div>
    </div>
</div>


{{-- SEKSI 6: DOKUMENTASI FOTO --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-slate-800 mb-6">
        <i class="fas fa-camera-retro mr-2 text-slate-500"></i>
        Dokumentasi Foto
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Foto Sebelum --}}
        <div>
            <label for="foto_sebelum" class="block text-sm font-medium text-slate-700">Foto Sebelum (0%)</label>
            @if (isset($jalanLingkungan) && $jalanLingkungan->foto_sebelum_url)
                <div class="mt-2 mb-2">
                    <img src="{{ $jalanLingkungan->foto_sebelum_url }}" alt="Foto Sebelum"
                        class="rounded-lg shadow-md max-h-48 w-auto">
                    <p class="text-xs text-slate-500 mt-1">Foto saat ini. Pilih file baru untuk mengganti.</p>
                </div>
            @endif
            <input type="file" name="foto_sebelum" id="foto_sebelum"
                class="mt-1 block w-full text-sm text-slate-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100">
            <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB.</p>
        </div>

        {{-- Foto Sesudah --}}
        <div>
            <label for="foto_sesudah" class="block text-sm font-medium text-slate-700">Foto Sesudah (100%)</label>
            @if (isset($jalanLingkungan) && $jalanLingkungan->foto_sesudah_url)
                <div class="mt-2 mb-2">
                    <img src="{{ $jalanLingkungan->foto_sesudah_url }}" alt="Foto Sesudah"
                        class="rounded-lg shadow-md max-h-48 w-auto">
                    <p class="text-xs text-slate-500 mt-1">Foto saat ini. Pilih file baru untuk mengganti.</p>
                </div>
            @endif
            <input type="file" name="foto_sesudah" id="foto_sesudah"
                class="mt-1 block w-full text-sm text-slate-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100">
            <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB.</p>
        </div>
    </div>
</div>


{{-- Tombol Aksi --}}
<div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-200 gap-4">
    <a href="{{ route('jalan_lingkungan.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center justify-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-save mr-2"></i>
        {{ isset($jalanLingkungan) ? 'Simpan Perubahan' : 'Simpan Data' }}
    </button>
</div>

@push('styles')
    <style>
        .input-style {
            @apply px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

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

            const oldKecamatan = "{{ old('kecamatan', $rumahTidakLayakHuni->kecamatan ?? '') }}";
            const oldDesa = "{{ old('desa', $rumahTidakLayakHuni->desa ?? '') }}";

            for (const kecamatan in data) {
                const option = document.createElement('option');
                option.value = kecamatan;
                option.textContent = kecamatan;
                if (kecamatan === oldKecamatan) {
                    option.selected = true;
                }
                kecamatanSelect.appendChild(option);
            }

            function populateDesa(selectedKecamatan, currentDesa) {
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';

                if (selectedKecamatan && data[selectedKecamatan]) {
                    desaSelect.disabled = false;
                    desaSelect.classList.remove('bg-slate-50', 'cursor-not-allowed');
                    const desas = data[selectedKecamatan];

                    desas.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa;
                        option.textContent = desa;
                        if (desa === currentDesa) {
                            option.selected = true;
                        }
                        desaSelect.appendChild(option);
                    });
                } else {
                    desaSelect.disabled = true;
                    desaSelect.classList.add('bg-slate-50', 'cursor-not-allowed');
                    desaSelect.innerHTML = '<option value="">Pilih Kecamatan Terlebih Dahulu</option>';
                }
            }

            kecamatanSelect.addEventListener('change', function() {
                populateDesa(this.value, '');
            });

            if (oldKecamatan) {
                populateDesa(oldKecamatan, oldDesa);
            }
        });
    </script>
@endpush
