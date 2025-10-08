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

<h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-6">
    Informasi Dasar
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="judul" class="block text-sm font-medium text-slate-700">Judul Dokumen</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $dokumen->judul ?? '') }}" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>
    <div>
        <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal Terbit/Diterima</label>
        <input type="date" id="tanggal" name="tanggal"
            value="{{ old('tanggal', isset($dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal)->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
    </div>
    <div>
        <label for="bidang_id" class="block text-sm font-medium text-slate-700">Bidang Terkait</label>
        {{-- Cek apakah pengguna adalah admin --}}
        @if (Auth::check() && Auth::user()->role == 'admin')

            {{-- JIKA ADMIN: Tampilkan dropdown untuk memilih bidang secara bebas --}}
            <select id="bidang_id" name="bidang_id" required
                class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                <option value="">-- Pilih Bidang --</option>
                @foreach ($bidangList as $bidang)
                    <option value="{{ $bidang->id }}" {{-- Logika untuk menangani data lama atau data yang sedang diedit --}}
                        {{ old('bidang_id', $dokumen->bidang_id ?? '') == $bidang->id ? 'selected' : '' }}>
                        {{ $bidang->nama_bidang }}
                    </option>
                @endforeach
            </select>
        @else
            {{-- JIKA BUKAN ADMIN: Kunci pilihan ke bidang milik user --}}
            <div>
                {{-- 1. Tampilkan select box yang nonaktif untuk antarmuka (UI) --}}
                <select disabled
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-slate-100 rounded-lg shadow-sm sm:text-sm cursor-not-allowed">
                    {{-- Asumsi: Model User memiliki relasi 'bidang' untuk mendapatkan nama --}}
                    <option>{{ Auth::user()->bidang->nama_bidang ?? 'Bidang tidak terdefinisi' }}</option>
                </select>
                <input type="hidden" name="bidang_id" value="{{ Auth::user()->bidang_id }}">
            </div>

        @endif
    </div>
    <div>
        <label for="kategori_select" class="block text-sm font-medium text-slate-700">Kategori</label>

        {{-- Dropdown untuk kategori yang sudah ada --}}
        <select id="kategori_select" name="kategori" required
            class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
            <option value="">-- Pilih Kategori --</option>

            {{-- Loop melalui kategori yang ada dari controller --}}
            @foreach ($kategoriList as $kategori)
                <option value="{{ $kategori }}" {{-- Logika untuk menangani data lama atau data yang sedang diedit --}}
                    {{ old('kategori', $dokumen->kategori ?? '') == $kategori ? 'selected' : '' }}>
                    {{ $kategori }}
                </option>
            @endforeach

            {{-- Opsi untuk menambahkan kategori baru --}}
            <option value="lainnya">-- Tambah Kategori Baru --</option>
        </select>

        {{-- Input untuk kategori baru, awalnya disembunyikan --}}
        <div id="kategori_baru_wrapper" class="hidden mt-2">
            <label for="kategori_baru" class="block text-xs font-medium text-slate-600 mb-1">Nama Kategori Baru</label>
            <input type="text" id="kategori_baru_input" name="kategori_baru"
                placeholder="Masukkan nama kategori baru"
                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
        </div>
    </div>
</div>

<div class="mt-6">
    <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi (Opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"
        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
</div>


{{-- PENGATURAN TIPE DOKUMEN & FILE --}}
<div class="mt-8 pt-6 border-t border-slate-200">
    <h3 class="text-xl font-semibold text-midnight_green mb-6">
        Pengaturan Dokumen & File
    </h3>
    <div class="p-6 border border-slate-200 rounded-lg bg-slate-50">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tipe_dokumen" class="block text-sm font-medium text-slate-700">Tipe Dokumen</label>
                <select id="tipe_dokumen" name="tipe_dokumen" required
                    class="mt-1 block w-full px-3 py-2 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-midnight_green-300 focus:border-midnight_green-300 sm:text-sm">
                    <option value="dokumen"
                        {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? 'dokumen') == 'dokumen' ? 'selected' : '' }}>
                        Dokumen Internal
                    </option>
                    <option value="surat"
                        {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'surat' ? 'selected' : '' }}>
                        Surat
                    </option>
                </select>
            </div>
            <div>
                <label for="file_dokumen" class="block text-sm font-medium text-slate-700">Upload File</label>
                <input type="file" id="file_dokumen" name="file_dokumen" {{ isset($dokumen) ? '' : 'required' }}
                    class="mt-1 block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white focus:outline-none file:bg-slate-200 file:text-slate-700 file:border-0 file:px-4 file:py-1.5 file:mr-4">
                @if (isset($dokumen) && $dokumen->file_path)
                    <p class="mt-2 text-sm text-slate-600">File saat ini: <a
                            href="{{ Storage::url($dokumen->file_path) }}" target="_blank"
                            class="font-semibold text-midnight_green hover:underline">Lihat File</a>
                    </p>
                    <small class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah file.</small>
                @endif
            </div>
        </div>

        {{-- Form tambahan yang hanya muncul jika tipe "Surat" dipilih --}}
        <div id="form-surat-fields" class="mt-6 border-t border-slate-300 pt-6" style="display: none;">
            <h4 class="text-md font-semibold text-slate-800 mb-4">Detail Surat</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="nomor_surat" class="block text-sm font-medium text-slate-700">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat"
                        value="{{ old('nomor_surat', $dokumen->nomor_surat ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-slate-700">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat"
                        value="{{ old('tanggal_surat', isset($dokumen->tanggal_surat) ? \Carbon\Carbon::parse($dokumen->tanggal_surat)->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="lampiran" class="block text-sm font-medium text-slate-700">Jml Lampiran</label>
                    <input type="number" name="lampiran" id="lampiran"
                        value="{{ old('lampiran', $dokumen->lampiran ?? '0') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
                <div class="lg:col-span-3">
                    <label for="perihal" class="block text-sm font-medium text-slate-700">Perihal</label>
                    <input type="text" name="perihal" id="perihal"
                        value="{{ old('perihal', $dokumen->perihal ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="pengirim" class="block text-sm font-medium text-slate-700">Pengirim</label>
                    <input type="text" name="pengirim" id="pengirim"
                        value="{{ old('pengirim', $dokumen->pengirim ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
                <div>
                    <label for="penerima" class="block text-sm font-medium text-slate-700">Penerima</label>
                    <input type="text" name="penerima" id="penerima"
                        value="{{ old('penerima', $dokumen->penerima ?? '') }}"
                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm sm:text-sm">
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Tombol Aksi --}}
<div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-200 gap-4">
    <button type="button" onclick="history.back()"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        Kembali
    </button>
    <button type="submit"
        class="inline-flex items-center justify-center px-6 py-2.5 bg-midnight_green-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-midnight_green-600">
        <i class="fas fa-save mr-2"></i>
        {{ isset($dokumen) ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>

{{-- Script sekarang diletakkan di sini menggunakan @push --}}
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

            // Jalankan fungsi saat halaman dimuat
            toggleSuratFields();

            // Jalankan fungsi setiap kali pilihan berubah
            tipeDokumenSelect.addEventListener('change', toggleSuratFields);

            const kategoriSelect = document.getElementById('kategori_select');
            const kategoriBaruWrapper = document.getElementById('kategori_baru_wrapper');
            const kategoriBaruInput = document.getElementById('kategori_baru_input');

            function toggleKategoriBaru() {
                if (kategoriSelect.value === 'lainnya') {
                    kategoriBaruWrapper.classList.remove('hidden'); // Tampilkan input
                    kategoriBaruInput.setAttribute('required', 'required'); // Wajibkan input ini
                } else {
                    kategoriBaruWrapper.classList.add('hidden'); // Sembunyikan input
                    kategoriBaruInput.removeAttribute('required'); // Hapus kewajiban
                    kategoriBaruInput.value = ''; // Kosongkan nilainya
                }
            }

            // Jalankan fungsi saat halaman dimuat (untuk handle old input atau edit)
            toggleKategoriBaru();

            // Jalankan fungsi setiap kali pilihan dropdown berubah
            kategoriSelect.addEventListener('change', toggleKategoriBaru);
        });
    </script>
@endpush
