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

{{-- SEKSI 1: DETAIL PEKERJAAN --}}
<h3 class="text-xl font-semibold text-slate-800 border-b border-slate-200 pb-4 mb-6">
    <i class="fas fa-road mr-2 text-slate-500"></i>
    Detail Pekerjaan
</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Uraian Pekerjaan --}}
    <div class="md:col-span-2">
        <label for="uraian" class="block text-sm font-medium text-slate-700">Uraian Pekerjaan</label>
        <input type="text" name="uraian" id="uraian" value="{{ old('uraian', $jalanLingkungan->uraian ?? '') }}"
            required placeholder="Contoh: Pembangunan Jalan Beton RT.01/RW.02"
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                <div>
                    <label for="no_spm_30" class="block text-sm font-medium text-slate-700">No. SPM</label>
                    <input type="text" name="no_spm_30" id="no_spm_30"
                        value="{{ old('no_spm_30', $jalanLingkungan->no_spm_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="no_sp2d_30" class="block text-sm font-medium text-slate-700">No. SP2D</label>
                    <input type="text" name="no_sp2d_30" id="no_sp2d_30"
                        value="{{ old('no_sp2d_30', $jalanLingkungan->no_sp2d_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="tanggal_30" class="block text-sm font-medium text-slate-700">Tanggal</label>
                    <input type="date" name="tanggal_30" id="tanggal_30"
                        value="{{ old('tanggal_30', isset($jalanLingkungan->tanggal_30) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_30)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="nilai_30" class="block text-sm font-medium text-slate-700">Nilai (Rp)</label>
                    <input type="number" name="nilai_30" id="nilai_30"
                        value="{{ old('nilai_30', $jalanLingkungan->nilai_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="ppn_30" class="block text-sm font-medium text-slate-700">PPN (Rp)</label>
                    <input type="number" name="ppn_30" id="ppn_30"
                        value="{{ old('ppn_30', $jalanLingkungan->ppn_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="pph_30" class="block text-sm font-medium text-slate-700">PPH (Rp)</label>
                    <input type="number" name="pph_30" id="pph_30"
                        value="{{ old('pph_30', $jalanLingkungan->pph_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div class="md:col-span-2">
                    <label for="total_30" class="block text-sm font-medium text-slate-700">Total Diterima (Rp)</label>
                    <input type="number" name="total_30" id="total_30"
                        value="{{ old('total_30', $jalanLingkungan->total_30 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
            </div>
        </div>

        {{-- Tahap 95% --}}
        <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
            <h4 class="text-lg font-semibold text-slate-700 mb-4 border-b border-slate-200 pb-2">Tahap 95%</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label for="no_spm_95" class="block text-sm font-medium text-slate-700">No. SPM</label>
                    <input type="text" name="no_spm_95" id="no_spm_95"
                        value="{{ old('no_spm_95', $jalanLingkungan->no_spm_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="no_sp2d_95" class="block text-sm font-medium text-slate-700">No. SP2D</label>
                    <input type="text" name="no_sp2d_95" id="no_sp2d_95"
                        value="{{ old('no_sp2d_95', $jalanLingkungan->no_sp2d_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="tanggal_95" class="block text-sm font-medium text-slate-700">Tanggal</label>
                    <input type="date" name="tanggal_95" id="tanggal_95"
                        value="{{ old('tanggal_95', isset($jalanLingkungan->tanggal_95) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_95)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="nilai_95" class="block text-sm font-medium text-slate-700">Nilai (Rp)</label>
                    <input type="number" name="nilai_95" id="nilai_95"
                        value="{{ old('nilai_95', $jalanLingkungan->nilai_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="ppn_95" class="block text-sm font-medium text-slate-700">PPN (Rp)</label>
                    <input type="number" name="ppn_95" id="ppn_95"
                        value="{{ old('ppn_95', $jalanLingkungan->ppn_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="pph_95" class="block text-sm font-medium text-slate-700">PPH (Rp)</label>
                    <input type="number" name="pph_95" id="pph_95"
                        value="{{ old('pph_95', $jalanLingkungan->pph_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div class="md:col-span-2">
                    <label for="total_95" class="block text-sm font-medium text-slate-700">Total Diterima (Rp)</label>
                    <input type="number" name="total_95" id="total_95"
                        value="{{ old('total_95', $jalanLingkungan->total_95 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
            </div>
        </div>

        {{-- Tahap 100% --}}
        <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
            <h4 class="text-lg font-semibold text-slate-700 mb-4 border-b border-slate-200 pb-2">Tahap 100%
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label for="no_spm_100" class="block text-sm font-medium text-slate-700">No. SPM</label>
                    <input type="text" name="no_spm_100" id="no_spm_100"
                        value="{{ old('no_spm_100', $jalanLingkungan->no_spm_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="no_sp2d_100" class="block text-sm font-medium text-slate-700">No. SP2D</label>
                    <input type="text" name="no_sp2d_100" id="no_sp2d_100"
                        value="{{ old('no_sp2d_100', $jalanLingkungan->no_sp2d_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="tanggal_100" class="block text-sm font-medium text-slate-700">Tanggal</label>
                    <input type="date" name="tanggal_100" id="tanggal_100"
                        value="{{ old('tanggal_100', isset($jalanLingkungan->tanggal_100) ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_100)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="nilai_100" class="block text-sm font-medium text-slate-700">Nilai (Rp)</label>
                    <input type="number" name="nilai_100" id="nilai_100"
                        value="{{ old('nilai_100', $jalanLingkungan->nilai_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="ppn_100" class="block text-sm font-medium text-slate-700">PPN (Rp)</label>
                    <input type="number" name="ppn_100" id="ppn_100"
                        value="{{ old('ppn_100', $jalanLingkungan->ppn_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div>
                    <label for="pph_100" class="block text-sm font-medium text-slate-700">PPH (Rp)</label>
                    <input type="number" name="pph_100" id="pph_100"
                        value="{{ old('pph_100', $jalanLingkungan->pph_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
                <div class="md:col-span-2">
                    <label for="total_100" class="block text-sm font-medium text-slate-700">Total Diterima
                        (Rp)</label>
                    <input type="number" name="total_100" id="total_100"
                        value="{{ old('total_100', $jalanLingkungan->total_100 ?? '') }}"
                        class="mt-1 block w-full input-style">
                </div>
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
