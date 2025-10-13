{{--
    File: resources/views/rtlh/_form.blade.php
    Description: Komponen form lengkap untuk data RTLH, disesuaikan dengan skema database terbaru.
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
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>

    {{-- Umur --}}
    <div>
        <label for="umur" class="block text-sm font-medium text-slate-700">Umur (Tahun)</label>
        <input type="number" name="umur" id="umur" value="{{ old('umur', $rumahTidakLayakHuni->umur ?? '') }}"
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
        <textarea name="alamat" id="alamat" rows="3"
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

{{-- SEKSI 2: DETAIL & KONDISI PROPERTI --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-midnight_green mb-6">
        Detail & Kondisi Properti
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Luas Rumah --}}
        <div>
            <label for="luas_rumah" class="block text-sm font-medium text-slate-700">Luas Rumah (M²)</label>
            <input type="number" step="0.01" name="luas_rumah" id="luas_rumah"
                value="{{ old('luas_rumah', $rumahTidakLayakHuni->luas_rumah ?? '') }}"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
        </div>

        {{-- Kepemilikan Tanah --}}
        <div>
            <label for="kepemilikan_tanah" class="block text-sm font-medium text-slate-700">Kepemilikan Tanah</label>
            <select name="kepemilikan_tanah" id="kepemilikan_tanah" required
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Jenis Kepemilikan --</option>
                <option value="Milik Sendiri" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Milik Sendiri')>Milik Sendiri</option>
                <option value="Warisan" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Warisan')>Warisan</option>
                <option value="Hibah" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Hibah')>Hibah</option>
                <option value="Sewa / Kontrak" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Sewa / Kontrak')>Sewa / Kontrak</option>
                <option value="Menumpang" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Menumpang')>Menumpang</option>
                <option value="Tanah Negara / Aset Pemerintah" @selected(old('kepemilikan_tanah', $rumahTidakLayakHuni->kepemilikan_tanah ?? '') == 'Tanah Negara / Aset Pemerintah')>Tanah Negara / Aset
                    Pemerintah</option>
            </select>
        </div>

        {{-- No Sertifikat --}}
        <div id="no_sertifikat_container">
            <label for="no_sertifikat" class="block text-sm font-medium text-slate-700">No. Dokumen/Sertifikat</label>
            <input type="text" name="no_sertifikat" id="no_sertifikat"
                value="{{ old('no_sertifikat', $rumahTidakLayakHuni->no_sertifikat ?? '') }}"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
        </div>

        {{-- Kondisi Atap --}}
        <div>
            <label for="kondisi_atap" class="block text-sm font-medium text-slate-700">Kondisi Atap</label>
            <select name="kondisi_atap" id="kondisi_atap"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" @selected(old('kondisi_atap', $rumahTidakLayakHuni->kondisi_atap ?? '') == 'Baik')>Baik</option>
                <option value="Rusak Ringan" @selected(old('kondisi_atap', $rumahTidakLayakHuni->kondisi_atap ?? '') == 'Rusak Ringan')>Rusak Ringan</option>
                <option value="Rusak Berat" @selected(old('kondisi_atap', $rumahTidakLayakHuni->kondisi_atap ?? '') == 'Rusak Berat')>Rusak Berat</option>
                <option value="Tidak Ada" @selected(old('kondisi_atap', $rumahTidakLayakHuni->kondisi_atap ?? '') == 'Tidak Ada')>Tidak Ada</option>
            </select>
        </div>

        {{-- Kondisi Dinding --}}
        <div>
            <label for="kondisi_dinding" class="block text-sm font-medium text-slate-700">Kondisi Dinding</label>
            <select name="kondisi_dinding" id="kondisi_dinding"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" @selected(old('kondisi_dinding', $rumahTidakLayakHuni->kondisi_dinding ?? '') == 'Baik')>Baik</option>
                <option value="Rusak Ringan" @selected(old('kondisi_dinding', $rumahTidakLayakHuni->kondisi_dinding ?? '') == 'Rusak Ringan')>Rusak Ringan</option>
                <option value="Rusak Berat" @selected(old('kondisi_dinding', $rumahTidakLayakHuni->kondisi_dinding ?? '') == 'Rusak Berat')>Rusak Berat</option>
                <option value="Tidak Ada" @selected(old('kondisi_dinding', $rumahTidakLayakHuni->kondisi_dinding ?? '') == 'Tidak Ada')>Tidak Ada</option>
            </select>
        </div>

        {{-- Kondisi Lantai --}}
        <div>
            <label for="kondisi_lantai" class="block text-sm font-medium text-slate-700">Kondisi Lantai</label>
            <select name="kondisi_lantai" id="kondisi_lantai"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" @selected(old('kondisi_lantai', $rumahTidakLayakHuni->kondisi_lantai ?? '') == 'Baik')>Baik</option>
                <option value="Rusak Ringan" @selected(old('kondisi_lantai', $rumahTidakLayakHuni->kondisi_lantai ?? '') == 'Rusak Ringan')>Rusak Ringan</option>
                <option value="Rusak Berat" @selected(old('kondisi_lantai', $rumahTidakLayakHuni->kondisi_lantai ?? '') == 'Rusak Berat')>Rusak Berat</option>
                <option value="Tidak Ada" @selected(old('kondisi_lantai', $rumahTidakLayakHuni->kondisi_lantai ?? '') == 'Tidak Ada')>Tidak Ada</option>
            </select>
        </div>

        {{-- Sumber Air --}}
        <div>
            <label for="sumber_air" class="block text-sm font-medium text-slate-700">Sumber Air Bersih</label>
            <select name="sumber_air" id="sumber_air"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Sumber Air --</option>
                <option value="PDAM" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'PDAM')>PDAM</option>
                <option value="Sumur Terlindungi" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'Sumur Terlindungi')>Sumur Terlindungi</option>
                <option value="Sumur Tidak Terlindungi" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'Sumur Tidak Terlindungi')>Sumur Tidak Terlindungi</option>
                <option value="Air Hujan" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'Air Hujan')>Air Hujan</option>
                <option value="Sungai/Danau" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'Sungai/Danau')>Sungai/Danau</option>
                <option value="Lainnya" @selected(old('sumber_air', $rumahTidakLayakHuni->sumber_air ?? '') == 'Lainnya')>Lainnya</option>
            </select>
        </div>

        {{-- Sanitasi/WC --}}
        <div>
            <label for="sanitasi_wc" class="block text-sm font-medium text-slate-700">Sanitasi / WC</label>
            <select name="sanitasi_wc" id="sanitasi_wc"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" @selected(old('sanitasi_wc', $rumahTidakLayakHuni->sanitasi_wc ?? '') == 'Baik')>Baik</option>
                <option value="Rusak Ringan" @selected(old('sanitasi_wc', $rumahTidakLayakHuni->sanitasi_wc ?? '') == 'Rusak Ringan')>Rusak Ringan</option>
                <option value="Rusak Berat" @selected(old('sanitasi_wc', $rumahTidakLayakHuni->sanitasi_wc ?? '') == 'Rusak Berat')>Rusak Berat</option>
                <option value="Tidak Ada" @selected(old('sanitasi_wc', $rumahTidakLayakHuni->sanitasi_wc ?? '') == 'Tidak Ada')>Tidak Ada</option>
            </select>
        </div>

        {{-- Dapur --}}
        <div class="md:col-span-2">
            <label for="dapur" class="block text-sm font-medium text-slate-700">Kondisi Dapur</label>
            <select name="dapur" id="dapur"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik" @selected(old('dapur', $rumahTidakLayakHuni->dapur ?? '') == 'Baik')>Baik</option>
                <option value="Rusak Ringan" @selected(old('dapur', $rumahTidakLayakHuni->dapur ?? '') == 'Rusak Ringan')>Rusak Ringan</option>
                <option value="Rusak Berat" @selected(old('dapur', $rumahTidakLayakHuni->dapur ?? '') == 'Rusak Berat')>Rusak Berat</option>
                <option value="Tidak Ada" @selected(old('dapur', $rumahTidakLayakHuni->dapur ?? '') == 'Tidak Ada')>Tidak Ada</option>
            </select>
        </div>

        {{-- Koordinat --}}
        <div class="md:col-span-2">
            <label for="koordinat" class="block text-sm font-medium text-slate-700">Koordinat</label>
            <input type="text" name="koordinat" id="koordinat"
                value="{{ old('koordinat', $rumahTidakLayakHuni->koordinat ?? '') }}"
                placeholder="Contoh: -7.2575, 112.7521"
                class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
        </div>
    </div>
</div>

{{-- SEKSI 3: DOKUMENTASI FOTO --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-midnight_green mb-6">
        Dokumentasi Foto
    </h3>
    <div class="space-y-6">
        {{-- Foto Rumah --}}
        <div>
            <label for="foto_rumah" class="block text-sm font-medium text-slate-700">Foto Rumah (Tampak Depan)</label>
            <input type="file" name="foto_rumah" id="foto_rumah"
                class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
            @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_rumah)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_rumah) }}" alt="Foto Rumah"
                        class="rounded-md border border-slate-300 h-32 w-auto">
                    <small class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>
            @endif
        </div>

        {{-- Foto Kondisi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4 border-t border-dashed">
            {{-- Foto Atap --}}
            <div>
                <label for="foto_kondisi_atap" class="block text-sm font-medium text-slate-700">Foto Kondisi
                    Atap</label>
                <input type="file" name="foto_kondisi_atap" id="foto_kondisi_atap"
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_kondisi_atap)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_kondisi_atap) }}" alt="Foto Atap"
                            class="rounded-md border border-slate-300 h-32 w-auto">
                    </div>
                @endif
            </div>
            {{-- Foto Dinding --}}
            <div>
                <label for="foto_kondisi_dinding" class="block text-sm font-medium text-slate-700">Foto Kondisi
                    Dinding</label>
                <input type="file" name="foto_kondisi_dinding" id="foto_kondisi_dinding"
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_kondisi_dinding)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_kondisi_dinding) }}"
                            alt="Foto Dinding" class="rounded-md border border-slate-300 h-32 w-auto">
                    </div>
                @endif
            </div>
            {{-- Foto Lantai --}}
            <div>
                <label for="foto_kondisi_lantai" class="block text-sm font-medium text-slate-700">Foto Kondisi
                    Lantai</label>
                <input type="file" name="foto_kondisi_lantai" id="foto_kondisi_lantai"
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_kondisi_lantai)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_kondisi_lantai) }}"
                            alt="Foto Lantai" class="rounded-md border border-slate-300 h-32 w-auto">
                    </div>
                @endif
            </div>
            {{-- Foto WC --}}
            <div>
                <label for="foto_sanitasi_wc" class="block text-sm font-medium text-slate-700">Foto Sanitasi /
                    WC</label>
                <input type="file" name="foto_sanitasi_wc" id="foto_sanitasi_wc"
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_sanitasi_wc)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sanitasi_wc) }}" alt="Foto WC"
                            class="rounded-md border border-slate-300 h-32 w-auto">
                    </div>
                @endif
            </div>
            {{-- Foto Dapur --}}
            <div>
                <label for="foto_kondisi_dapur" class="block text-sm font-medium text-slate-700">Foto Kondisi
                    Dapur</label>
                <input type="file" name="foto_kondisi_dapur" id="foto_kondisi_dapur"
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($rumahTidakLayakHuni) && $rumahTidakLayakHuni->foto_kondisi_dapur)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_kondisi_dapur) }}"
                            alt="Foto Dapur" class="rounded-md border border-slate-300 h-32 w-auto">
                    </div>
                @endif
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

            const oldKecamatan = "{{ old('kecamatan', $rumahTidakLayakHuni->kecamatan ?? '') }}";
            const oldDesa = "{{ old('desa_kelurahan', $rumahTidakLayakHuni->desa_kelurahan ?? '') }}";

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

            // Script untuk menampilkan/menyembunyikan field No. Sertifikat
            const kepemilikanTanahSelect = document.getElementById('kepemilikan_tanah');
            const noSertifikatContainer = document.getElementById('no_sertifikat_container');
            const optionsWithNumber = ['Milik Sendiri', 'Warisan', 'Hibah'];

            function toggleNoSertifikatField() {
                const selectedValue = kepemilikanTanahSelect.value;
                if (optionsWithNumber.includes(selectedValue)) {
                    noSertifikatContainer.style.display = 'block';
                } else {
                    noSertifikatContainer.style.display = 'none';
                }
            }

            kepemilikanTanahSelect.addEventListener('change', toggleNoSertifikatField);
            toggleNoSertifikatField(); // Panggil saat halaman dimuat
        });
    </script>
@endpush
