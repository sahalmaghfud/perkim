{{-- Menampilkan error validasi jika ada --}}
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <p class="font-bold">Terjadi Kesalahan:</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $dokumen->judul ?? '') }}" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
        {{-- [PENYESUAIAN] Mengganti 'tanggal_terbit' menjadi 'tanggal' --}}
        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Terbit/Diterima</label>
        <input type="date" id="tanggal" name="tanggal"
            value="{{ old('tanggal', isset($dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal)->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        {{-- [PENYESUAIAN] Mengganti 'divisi' menjadi 'bidang' --}}
        <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang Terkait</label>
        <select id="bidang_id" name="bidang_id" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach ($bidangList as $bidang)
                <option value="{{ $bidang->id }}"
                    {{ old('bidang_id', $dokumen->bidang_id ?? '') == $bidang->id ? 'selected' : '' }}>
                    {{ $bidang->nama_bidang }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
        {{-- Anda bisa membuat ini dinamis jika diperlukan --}}
        <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $dokumen->kategori ?? '') }}"
            required placeholder="Contoh: Keuangan, Teknis, Undangan"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

<div class="mt-6">
    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
</div>

{{-- ====================================================================== --}}
{{-- BAGIAN TIPE DOKUMEN & FORM SURAT (DINAMIS) --}}
{{-- ====================================================================== --}}
<div class="mt-6 p-4 border border-gray-200 rounded-md bg-gray-50">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            {{-- [PENYESUAIAN] Opsi 'tipe_dokumen' disesuaikan dengan enum database --}}
            <label for="tipe_dokumen" class="block text-sm font-medium text-gray-700">Tipe Dokumen</label>
            <select id="tipe_dokumen" name="tipe_dokumen" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="dokumen"
                    {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? 'dokumen') == 'dokumen' ? 'selected' : '' }}>
                    Dokumen Internal</option>
                <option value="surat"
                    {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'surat' ? 'selected' : '' }}>
                    Surat</option>
            </select>
        </div>
        <div>
            <label for="file_dokumen" class="block text-sm font-medium text-gray-700">File Dokumen</label>
            <input type="file" id="file_dokumen" name="file_dokumen" {{ isset($dokumen) ? '' : 'required' }}
                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none file:bg-gray-200 file:text-gray-700 file:border-0 file:px-4 file:py-2">
            @if (isset($dokumen) && $dokumen->file_path)
                <p class="mt-2 text-sm text-gray-600">File saat ini: <a href="{{ Storage::url($dokumen->file_path) }}"
                        target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat File</a></p>
                <small class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file.</small>
            @endif
        </div>
    </div>

    {{-- [BARU] Form tambahan yang hanya muncul jika tipe "Surat" dipilih --}}
    <div id="form-surat-fields" class="mt-6 border-t border-gray-300 pt-6" style="display: none;">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Detail Surat</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat"
                    value="{{ old('nomor_surat', $dokumen->nomor_surat ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div>
                <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                <input type="date" name="tanggal_surat" id="tanggal_surat"
                    value="{{ old('tanggal_surat', isset($dokumen->tanggal_surat) ? \Carbon\Carbon::parse($dokumen->tanggal_surat)->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div>
                <label for="lampiran" class="block text-sm font-medium text-gray-700">Jumlah Lampiran</label>
                <input type="number" name="lampiran" id="lampiran"
                    value="{{ old('lampiran', $dokumen->lampiran ?? '0') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div class="lg:col-span-3">
                <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                <input type="text" name="perihal" id="perihal"
                    value="{{ old('perihal', $dokumen->perihal ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div>
                <label for="pengirim" class="block text-sm font-medium text-gray-700">Pengirim</label>
                <input type="text" name="pengirim" id="pengirim"
                    value="{{ old('pengirim', $dokumen->pengirim ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div>
                <label for="penerima" class="block text-sm font-medium text-gray-700">Penerima</label>
                <input type="text" name="penerima" id="penerima"
                    value="{{ old('penerima', $dokumen->penerima ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
        </div>
    </div>
</div>


{{-- Tombol Aksi --}}
<div class="flex items-center justify-end mt-8 gap-4">
    <a href="{{ route('dokumen.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
        {{ isset($dokumen) ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipeDokumenSelect = document.getElementById('tipe_dokumen');
            const suratFields = document.getElementById('form-surat-fields');

            function toggleSuratFields() {
                if (tipeDokumenSelect.value === 'surat') {
                    suratFields.style.display = 'block';
                } else {
                    suratFields.style.display = 'none';
                }
            }

            // Jalankan fungsi saat halaman dimuat (untuk form edit)
            toggleSuratFields();

            // Jalankan fungsi setiap kali pilihan berubah
            tipeDokumenSelect.addEventListener('change', toggleSuratFields);
        });
    </script>
@endpush
