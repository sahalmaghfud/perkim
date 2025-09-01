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

{{-- Grid untuk layout --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="kode_dokumen" class="block text-sm font-medium text-gray-700">Kode Dokumen (Opsional)</label>
        <input type="text" id="kode_dokumen" name="kode_dokumen"
            value="{{ old('kode_dokumen', $dokumen->kode_dokumen ?? '') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
        <label for="tanggal_terbit" class="block text-sm font-medium text-gray-700">Tanggal Terbit</label>
        <input type="date" id="tanggal_terbit" name="tanggal_terbit"
            value="{{ old('tanggal_terbit', isset($dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_terbit)->format('Y-m-d') : '') }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

<div class="mt-6">
    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
    <input type="text" id="judul" name="judul" value="{{ old('judul', $dokumen->judul ?? '') }}" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
</div>

<div class="mt-6">
    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="4"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select id="kategori" name="kategori" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            {{-- Sebaiknya daftar ini didapat dari controller atau config --}}
            <option value="Keuangan" {{ old('kategori', $dokumen->kategori ?? '') == 'Keuangan' ? 'selected' : '' }}>
                Keuangan</option>
            <option value="HRD" {{ old('kategori', $dokumen->kategori ?? '') == 'HRD' ? 'selected' : '' }}>HRD
            </option>
            <option value="Teknis" {{ old('kategori', $dokumen->kategori ?? '') == 'Teknis' ? 'selected' : '' }}>Teknis
            </option>
            <option value="Marketing" {{ old('kategori', $dokumen->kategori ?? '') == 'Marketing' ? 'selected' : '' }}>
                Marketing</option>
            <option value="Umum" {{ old('kategori', $dokumen->kategori ?? '') == 'Umum' ? 'selected' : '' }}>Umum
            </option>
        </select>
    </div>
    <div>
        <label for="tipe_dokumen" class="block text-sm font-medium text-gray-700">Tipe Dokumen</label>
        <select id="tipe_dokumen" name="tipe_dokumen" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            {{-- Sebaiknya daftar ini didapat dari controller atau config --}}
            <option value="SOP" {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'SOP' ? 'selected' : '' }}>
                SOP</option>
            <option value="Laporan Bulanan"
                {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'Laporan Bulanan' ? 'selected' : '' }}>Laporan
                Bulanan</option>
            <option value="Kontrak"
                {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            <option value="Surat Masuk"
                {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'Surat Masuk' ? 'selected' : '' }}>Surat Masuk
            </option>
            <option value="Surat Keluar"
                {{ old('tipe_dokumen', $dokumen->tipe_dokumen ?? '') == 'Surat Keluar' ? 'selected' : '' }}>Surat
                Keluar</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label for="divisi_id" class="block text-sm font-medium text-gray-700">Divisi Terkait</label>
        <select id="divisi_id" name="divisi_id" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach ($divisiList as $divisi)
                <option value="{{ $divisi->id }}"
                    {{ old('divisi_id', $dokumen->divisi_id ?? '') == $divisi->id ? 'selected' : '' }}>
                    {{ $divisi->nama_divisi }}
                </option>
            @endforeach
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
<div class="flex items-center justify-end mt-8 gap-4">
    <a href="{{ route('dokumen.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
        {{ isset($dokumen) ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>
