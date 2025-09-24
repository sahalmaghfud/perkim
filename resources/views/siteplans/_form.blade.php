@extends('layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <form action="{{ route('siteplans.update', $siteplan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <header class="mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-800">
                                Edit Siteplan
                            </h1>
                            <p class="mt-1 text-md text-slate-500">
                                Memperbarui data untuk <span
                                    class="font-semibold text-slate-600">{{ $siteplan->nama }}</span>
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('siteplans.show', $siteplan->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border-2 border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 hover:border-slate-400">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border-2 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </header>

                <div class="space-y-8">

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800">Informasi Proyek</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama Perumahan
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    value="{{ old('nama', $siteplan->nama) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="nama_pt" class="block text-sm font-medium text-slate-700 mb-1">Nama PT <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_pt" id="nama_pt"
                                    value="{{ old('nama_pt', $siteplan->nama_pt) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">{{ old('alamat', $siteplan->alamat) }}</textarea>
                            </div>
                            <div>
                                <label for="kecamatan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div>
                                <label for="desa"
                                    class="block text-sm font-medium text-slate-700 mb-1">Desa/Kelurahan</label>
                                <select name="desa" id="desa" disabled
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm bg-slate-50 cursor-not-allowed px-3 py-2">
                                    <option value="">Pilih Kecamatan dulu</option>
                                </select>
                            </div>
                            <div>
                                <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1">Jenis</label>
                                <input type="text" name="jenis" id="jenis"
                                    value="{{ old('jenis', $siteplan->jenis) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2"
                                    placeholder="MBR / Komersil">
                            </div>
                            <div>
                                <label for="tipe" class="block text-sm font-medium text-slate-700 mb-1">Tipe <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tipe" id="tipe"
                                    value="{{ old('tipe', $siteplan->tipe) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2"
                                    placeholder="Contoh: 36/72">
                            </div>
                            <div>
                                <label for="jumlah_unit_rumah" class="block text-sm font-medium text-slate-700 mb-1">Jumlah
                                    Unit</label>
                                <input type="number" name="jumlah_unit_rumah" id="jumlah_unit_rumah"
                                    value="{{ old('jumlah_unit_rumah', $siteplan->jumlah_unit_rumah) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                                <input type="number" name="tahun" id="tahun"
                                    value="{{ old('tahun', $siteplan->tahun) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2"
                                    placeholder="YYYY">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800">Detail Lahan</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="luas_lahan_per_unit" class="block text-sm font-medium text-slate-700 mb-1">Luas
                                    Lahan per Unit</label>
                                <input type="text" name="luas_lahan_per_unit" id="luas_lahan_per_unit"
                                    value="{{ old('luas_lahan_per_unit', $siteplan->luas_lahan_per_unit) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_lahan_perumahan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Total Luas Lahan (m²)</label>
                                <input type="number" step="0.01" name="luas_lahan_perumahan"
                                    id="luas_lahan_perumahan"
                                    value="{{ old('luas_lahan_perumahan', $siteplan->luas_lahan_perumahan) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_psu" class="block text-sm font-medium text-slate-700 mb-1">Total Luas PSU
                                    (m²)</label>
                                <input type="number" step="0.01" name="luas_psu" id="luas_psu"
                                    value="{{ old('luas_psu', $siteplan->luas_psu) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800">Legalitas & Administrasi</h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="nomor_site_plan" class="block text-sm font-medium text-slate-700 mb-1">Nomor
                                    Site Plan</label>
                                <input type="text" name="nomor_site_plan" id="nomor_site_plan"
                                    value="{{ old('nomor_site_plan', $siteplan->nomor_site_plan) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="tanggal_site_plan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Tanggal Site Plan</label>
                                <input type="date" name="tanggal_site_plan" id="tanggal_site_plan"
                                    value="{{ old('tanggal_site_plan', optional($siteplan->tanggal_site_plan)->format('Y-m-d')) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="nomor_bast_adm" class="block text-sm font-medium text-slate-700 mb-1">Nomor
                                    BAST Administrasi</label>
                                <input type="text" name="nomor_bast_adm" id="nomor_bast_adm"
                                    value="{{ old('nomor_bast_adm', $siteplan->nomor_bast_adm) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="tanggal_bast_adm"
                                    class="block text-sm font-medium text-slate-700 mb-1">Tanggal BAST Administrasi</label>
                                <input type="date" name="tanggal_bast_adm" id="tanggal_bast_adm"
                                    value="{{ old('tanggal_bast_adm', optional($siteplan->tanggal_bast_adm)->format('Y-m-d')) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="nomor_bast_fisik" class="block text-sm font-medium text-slate-700 mb-1">Nomor
                                    BAST Fisik</label>
                                <input type="text" name="nomor_bast_fisik" id="nomor_bast_fisik"
                                    value="{{ old('nomor_bast_fisik', $siteplan->nomor_bast_fisik) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="tanggal_bast_fisik"
                                    class="block text-sm font-medium text-slate-700 mb-1">Tanggal BAST Fisik</label>
                                <input type="date" name="tanggal_bast_fisik" id="tanggal_bast_fisik"
                                    value="{{ old('tanggal_bast_fisik', optional($siteplan->tanggal_bast_fisik)->format('Y-m-d')) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                                <select name="keterangan" id="keterangan"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                                    <option value="Jatuh Tempo"
                                        {{ old('keterangan', $siteplan->keterangan) == 'Jatuh Tempo' ? 'selected' : '' }}>
                                        Jatuh Tempo</option>
                                    <option value="Proses"
                                        {{ old('keterangan', $siteplan->keterangan) == 'Proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="Selesai"
                                        {{ old('keterangan', $siteplan->keterangan) == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800">Rincian Prasarana, Sarana, dan Utilitas (PSU)
                            </h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="panjang_prasarana_jalan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Panjang Jalan (m)</label>
                                <input type="number" step="0.01" name="panjang_prasarana_jalan"
                                    id="panjang_prasarana_jalan"
                                    value="{{ old('panjang_prasarana_jalan', $siteplan->panjang_prasarana_jalan) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="lebar_prasarana_jalan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Lebar Jalan (m)</label>
                                <input type="number" step="0.01" name="lebar_prasarana_jalan"
                                    id="lebar_prasarana_jalan"
                                    value="{{ old('lebar_prasarana_jalan', $siteplan->lebar_prasarana_jalan) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_prasarana_jalan"
                                    class="block text-sm font-medium text-slate-700 mb-1">Luas Jalan (m²)</label>
                                <input type="number" step="0.01" name="luas_prasarana_jalan"
                                    id="luas_prasarana_jalan"
                                    value="{{ old('luas_prasarana_jalan', $siteplan->luas_prasarana_jalan) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_prasarana_drainase"
                                    class="block text-sm font-medium text-slate-700 mb-1">Luas Drainase (m²)</label>
                                <input type="number" step="0.01" name="luas_prasarana_drainase"
                                    id="luas_prasarana_drainase"
                                    value="{{ old('luas_prasarana_drainase', $siteplan->luas_prasarana_drainase) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_prasarana_rth" class="block text-sm font-medium text-slate-700 mb-1">Luas
                                    RTH (m²)</label>
                                <input type="number" step="0.01" name="luas_prasarana_rth" id="luas_prasarana_rth"
                                    value="{{ old('luas_prasarana_rth', $siteplan->luas_prasarana_rth) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_prasarana_tps" class="block text-sm font-medium text-slate-700 mb-1">Luas
                                    TPS (m²)</label>
                                <input type="number" step="0.01" name="luas_prasarana_tps" id="luas_prasarana_tps"
                                    value="{{ old('luas_prasarana_tps', $siteplan->luas_prasarana_tps) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_sarana_pemakaman"
                                    class="block text-sm font-medium text-slate-700 mb-1">Luas Pemakaman (m²)</label>
                                <input type="number" step="0.01" name="luas_sarana_pemakaman"
                                    id="luas_sarana_pemakaman"
                                    value="{{ old('luas_sarana_pemakaman', $siteplan->luas_sarana_pemakaman) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="luas_sarana_olahraga_dll"
                                    class="block text-sm font-medium text-slate-700 mb-1">Luas Olahraga/Dll (m²)</label>
                                <input type="number" step="0.01" name="luas_sarana_olahraga_dll"
                                    id="luas_sarana_olahraga_dll"
                                    value="{{ old('luas_sarana_olahraga_dll', $siteplan->luas_sarana_olahraga_dll) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="panjang_utilitas"
                                    class="block text-sm font-medium text-slate-700 mb-1">Panjang Utilitas</label>
                                <input type="text" name="panjang_utilitas" id="panjang_utilitas"
                                    value="{{ old('panjang_utilitas', $siteplan->panjang_utilitas) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2">
                            </div>
                            <div>
                                <label for="sumber_air_bersih"
                                    class="block text-sm font-medium text-slate-700 mb-1">Sumber Air Bersih</label>
                                <input type="text" name="sumber_air_bersih" id="sumber_air_bersih"
                                    value="{{ old('sumber_air_bersih', $siteplan->sumber_air_bersih) }}"
                                    class="block w-full border-2 border-slate-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 px-3 py-2"
                                    placeholder="PDAM/Sumur Bor">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200">
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800">Dokumen Siteplan</h2>
                        </div>
                        <div class="p-6">
                            <label for="file_path" class="block text-sm font-medium text-slate-700 mb-2">Upload File Baru
                                (Opsional)</label>
                            <p class="text-xs text-slate-500 mb-3">Mengupload file baru akan menggantikan file yang lama.
                            </p>
                            <input type="file" name="file_path" id="file_path"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 px-3 py-2" />
                            @if ($siteplan->file_path)
                                <div class="mt-4 text-sm">
                                    <span class="text-slate-600">File saat ini:</span>
                                    <a href="{{ Storage::url($siteplan->file_path) }}" target="_blank"
                                        class="font-medium text-indigo-600 hover:text-indigo-800 underline">
                                        {{ basename($siteplan->file_path) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border-2 border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

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

            const oldKecamatan = "{{ old('kecamatan', $siteplan->kecamatan) }}";
            const oldDesa = "{{ old('desa', $siteplan->desa) }}";

            for (const kecamatan in data) {
                const option = document.createElement('option');
                option.value = kecamatan;
                option.textContent = kecamatan;
                if (kecamatan === oldKecamatan) {
                    option.selected = true;
                }
                kecamatanSelect.appendChild(option);
            }

            function populateDesa(selectedKecamatan) {
                let currentDesa = oldDesa;
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
                populateDesa(this.value);
            });

            if (oldKecamatan) {
                populateDesa(oldKecamatan);
            }
        });
    </script>
@endpush
