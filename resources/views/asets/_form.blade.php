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

{{-- =================================================================================== --}}
{{-- BAGIAN UMUM (SELALU TAMPIL) --}}
{{-- =================================================================================== --}}
<h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-6">
    <i class="fas fa-info-circle mr-2 text-midnight_green-400"></i>
    Informasi Umum Aset
</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="jenis_kib" class="block text-sm font-medium text-slate-700">Jenis KIB</label>
        <select name="jenis_kib" id="jenis_kib" class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm"
            required>
            <option value="" disabled {{ !isset($aset) ? 'selected' : '' }}>Pilih Jenis KIB...</option>
            <option value="A" @if (isset($aset) && $aset->jenis_kib == 'A') selected @endif>A - Tanah</option>
            <option value="B" @if (isset($aset) && $aset->jenis_kib == 'B') selected @endif>B - Peralatan dan Mesin</option>
            <option value="C" @if (isset($aset) && $aset->jenis_kib == 'C') selected @endif>C - Gedung dan Bangunan</option>
            <option value="D" @if (isset($aset) && $aset->jenis_kib == 'D') selected @endif>D - Jalan, Irigasi, Jaringan
            </option>
            <option value="F" @if (isset($aset) && $aset->jenis_kib == 'F') selected @endif>F - Konstruksi Dalam Pengerjaan
            </option>
            <option value="G" @if (isset($aset) && $aset->jenis_kib == 'G') selected @endif>G - Aset Tak Berwujud</option>
            <option value="H" @if (isset($aset) && $aset->jenis_kib == 'H') selected @endif>H - Aset Lain-Lain</option>
        </select>
    </div>
    <div>
        <label for="kode_barang" class="block text-sm font-medium text-slate-700">Kode Barang</label>
        <input type="text" name="kode_barang" id="kode_barang"
            value="{{ old('kode_barang', $aset->kode_barang ?? '') }}"
            class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm" required>
    </div>
    <div class="md:col-span-2">
        <label for="nama_barang" class="block text-sm font-medium text-slate-700">Nama Barang</label>
        <input type="text" name="nama_barang" id="nama_barang"
            value="{{ old('nama_barang', $aset->nama_barang ?? '') }}"
            class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm" required>
    </div>
    <div>
        <label for="tahun_perolehan" class="block text-sm font-medium text-slate-700">Tahun Perolehan</label>
        <input type="number" name="tahun_perolehan" id="tahun_perolehan"
            value="{{ old('tahun_perolehan', $aset->tahun_perolehan ?? '') }}" placeholder="YYYY"
            class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm" required>
    </div>
    <div>
        <label for="nilai_perolehan_rp" class="block text-sm font-medium text-slate-700">Nilai Perolehan (Rp)</label>
        <input type="number" step="0.01" name="nilai_perolehan_rp" id="nilai_perolehan_rp"
            value="{{ old('nilai_perolehan_rp', $aset->nilai_perolehan_rp ?? '') }}"
            class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm" required>
    </div>
    <div class="md:col-span-2">
        <label for="foto_barang" class="block text-sm font-medium text-slate-700">Foto Barang</label>
        <div class="mt-2 flex items-center gap-6">

            <div>
                <input type="file" name="foto_barang" id="foto_barang" accept="image/*"
                    class="block w-full text-sm text-slate-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-midnight_green-50 file:text-midnight_green-700
                              hover:file:bg-midnight_green-100">
                <p class="mt-2 text-xs text-slate-500">
                    Kosongkan jika tidak ingin mengubah foto. Tipe file: JPG, PNG, GIF. Maks: 2MB.
                </p>
            </div>
        </div>
    </div>

</div>

{{-- =================================================================================== --}}
{{-- BAGIAN DINAMIS (BERDASARKAN JENIS KIB) --}}
{{-- =================================================================================== --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-midnight_green mb-6">
        <i class="fas fa-cogs mr-2 text-midnight_green-400"></i>
        Detail Spesifik Aset
    </h3>
    <div id="dynamic-fields-container"
        class="p-6 border border-slate-200 rounded-lg bg-slate-50 min-h-[10rem] transition-all duration-300">
        <div id="no-fields-message" class="hidden">
            <p class="text-sm text-center text-gray-500">Tidak ada detail spesifik untuk jenis KIB ini.</p>
        </div>

        {{-- KIB A & F: Bagian Registrasi Aset --}}
        <div class="kib-fields space-y-6" id="kib-af-fields" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nomor_induk_barang" class="block text-sm font-medium text-slate-700">Nomor Induk
                        Barang</label>
                    <input type="text" name="nomor_induk_barang"
                        value="{{ old('nomor_induk_barang', $aset->nomor_induk_barang ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="nomor_register" class="block text-sm font-medium text-slate-700">Nomor
                        Register</label>
                    <input type="text" name="nomor_register"
                        value="{{ old('nomor_register', $aset->nomor_register ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="cara_perolehan" class="block text-sm font-medium text-slate-700">Cara
                        Perolehan</label>
                    <input type="text" name="cara_perolehan"
                        value="{{ old('cara_perolehan', $aset->cara_perolehan ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="status_pengguna" class="block text-sm font-medium text-slate-700">Status
                        Pengguna</label>
                    <input type="text" name="status_pengguna"
                        value="{{ old('status_pengguna', $aset->status_pengguna ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
            </div>
        </div>

        {{-- KIB A: TANAH (Field yang hanya ada di KIB A) --}}
        <div class="kib-fields space-y-6" id="kib-a-fields" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="luas" class="block text-sm font-medium text-slate-700">Luas (M2)</label>
                    <input type="number" step="0.01" name="luas"
                        value="{{ old('luas', $aset->luas ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="lokasi_alamat" class="block text-sm font-medium text-slate-700">Lokasi /
                        Alamat</label>
                    <input type="text" name="lokasi_alamat"
                        value="{{ old('lokasi_alamat', $aset->lokasi_alamat ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="hak" class="block text-sm font-medium text-slate-700">Status Hak
                        Tanah</label>
                    <input type="text" name="hak" value="{{ old('hak', $aset->hak ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="nomor_sertifikat" class="block text-sm font-medium text-slate-700">Nomor
                        Sertifikat</label>
                    <input type="text" name="nomor_sertifikat"
                        value="{{ old('nomor_sertifikat', $aset->nomor_sertifikat ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="tanggal_sertifikat" class="block text-sm font-medium text-slate-700">Tanggal
                        Sertifikat</label>
                    <input type="date" name="tanggal_sertifikat"
                        value="{{ old('tanggal_sertifikat', $aset->tanggal_sertifikat ? \Carbon\Carbon::parse($aset->tanggal_sertifikat)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="nama_kepemilikan" class="block text-sm font-medium text-slate-700">Nama
                        Kepemilikan</label>
                    <input type="text" name="nama_kepemilikan"
                        value="{{ old('nama_kepemilikan', $aset->nama_kepemilikan ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
            </div>
        </div>

        {{-- KIB B, C, D, G, H: PENYUSUTAN --}}
        <div class="kib-fields space-y-6" id="kib-penyusutan-fields" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div id="umur-ekonomis-wrapper" style="display: none;">
                    <label for="umur_ekonomis_tahun" class="block text-sm font-medium text-slate-700">Umur
                        Ekonomis
                        (Thn)</label>
                    <input type="number" name="umur_ekonomis_tahun"
                        value="{{ old('umur_ekonomis_tahun', $aset->umur_ekonomis_tahun ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="akumulasi_penyusutan_awal" class="block text-sm font-medium text-slate-700">Akumulasi
                        Penyusutan Awal</label>
                    <input type="number" step="0.01" name="akumulasi_penyusutan_awal"
                        value="{{ old('akumulasi_penyusutan_awal', $aset->akumulasi_penyusutan_awal ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="beban_penyusutan_tahunan" class="block text-sm font-medium text-slate-700">Beban
                        Penyusutan Tahunan</label>
                    <input type="number" step="0.01" name="beban_penyusutan_tahunan"
                        value="{{ old('beban_penyusutan_tahunan', $aset->beban_penyusutan_tahunan ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="akumulasi_penyusutan_akhir" class="block text-sm font-medium text-slate-700">Akumulasi
                        Penyusutan Akhir</label>
                    <input type="number" step="0.01" name="akumulasi_penyusutan_akhir"
                        value="{{ old('akumulasi_penyusutan_akhir', $aset->akumulasi_penyusutan_akhir ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label for="nilai_buku" class="block text-sm font-medium text-slate-700">Nilai Buku
                        (Rp)</label>
                    <input type="number" step="0.01" name="nilai_buku"
                        value="{{ old('nilai_buku', $aset->nilai_buku ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-200 gap-4">
    <a href="{{ route('asets.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center justify-center px-6 py-2.5 bg-midnight_green-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-midnight_green-600">
        <i class="fas fa-save mr-2"></i>
        {{ isset($aset) ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kibSelect = document.getElementById('jenis_kib');
            const noFieldsMessage = document.getElementById('no-fields-message');

            const kibFieldMapping = {
                'A': ['kib-af-fields', 'kib-a-fields'],
                'B': ['kib-penyusutan-fields'],
                'C': ['kib-penyusutan-fields'],
                'D': ['kib-penyusutan-fields'],
                'F': ['kib-af-fields'],
                'G': ['kib-penyusutan-fields'],
                'H': ['kib-penyusutan-fields']
            };

            function toggleFields() {
                const selectedKib = kibSelect.value;
                let hasVisibleFields = false;

                document.querySelectorAll('.kib-fields').forEach(group => {
                    group.style.display = 'none';
                });

                if (kibFieldMapping[selectedKib] && kibFieldMapping[selectedKib].length > 0) {
                    hasVisibleFields = true;
                    kibFieldMapping[selectedKib].forEach(groupId => {
                        const groupElement = document.getElementById(groupId);
                        if (groupElement) {
                            groupElement.style.display = 'block';
                        }
                    });
                }

                const umurEkonomisWrapper = document.getElementById('umur-ekonomis-wrapper');
                if (selectedKib === 'C' || selectedKib === 'D') {
                    umurEkonomisWrapper.style.display = 'block';
                    hasVisibleFields = true;
                } else {
                    umurEkonomisWrapper.style.display = 'none';
                }

                noFieldsMessage.style.display = hasVisibleFields ? 'none' : 'block';
            }

            kibSelect.addEventListener('change', toggleFields);
            toggleFields();
        });
    </script>
@endpush
