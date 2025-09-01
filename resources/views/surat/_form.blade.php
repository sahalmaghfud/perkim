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

{{-- Grid untuk layout 2 kolom di layar medium ke atas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
        <input type="text" id="nomor_surat" name="nomor_surat"
            value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
        <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
        <input type="date" id="tanggal_surat" name="tanggal_surat"
            value="{{ old('tanggal_surat', isset($surat) ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d') : '') }}"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

<div class="mt-6">
    <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
    <textarea id="perihal" name="perihal" rows="3" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('perihal', $surat->perihal ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label for="jenis_surat" class="block text-sm font-medium text-gray-700">Jenis Surat</label>
        <select id="jenis_surat" name="jenis_surat" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="Surat Masuk"
                {{ old('jenis_surat', $surat->jenis_surat ?? '') == 'Surat Masuk' ? 'selected' : '' }}>Surat Masuk
            </option>
            <option value="Surat Keluar"
                {{ old('jenis_surat', $surat->jenis_surat ?? '') == 'Surat Keluar' ? 'selected' : '' }}>Surat Keluar
            </option>
        </select>
    </div>
    <div>
        <label for="sifat" class="block text-sm font-medium text-gray-700">Sifat Surat</label>
        <select id="sifat" name="sifat" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="Biasa" {{ old('sifat', $surat->sifat ?? '') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
            <option value="Penting" {{ old('sifat', $surat->sifat ?? '') == 'Penting' ? 'selected' : '' }}>Penting
            </option>
            <option value="Rahasia" {{ old('sifat', $surat->sifat ?? '') == 'Rahasia' ? 'selected' : '' }}>Rahasia
            </option>
            <option value="Sangat Rahasia"
                {{ old('sifat', $surat->sifat ?? '') == 'Sangat Rahasia' ? 'selected' : '' }}>Sangat Rahasia</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label for="pengirim" class="block text-sm font-medium text-gray-700">Pengirim (Jika Surat Masuk)</label>
        <input type="text" id="pengirim" name="pengirim" value="{{ old('pengirim', $surat->pengirim ?? '') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
        <label for="penerima" class="block text-sm font-medium text-gray-700">Penerima (Jika Surat Keluar)</label>
        <input type="text" id="penerima" name="penerima" value="{{ old('penerima', $surat->penerima ?? '') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
</div>

<div class="mt-6">
    <label for="divisi_id" class="block text-sm font-medium text-gray-700">Divisi Tujuan/Pembuat</label>
    <select id="divisi_id" name="divisi_id" required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        @foreach ($divisiList as $divisi)
            <option value="{{ $divisi->id }}"
                {{ old('divisi_id', $surat->divisi_id ?? ($selectedDivisiId ?? '')) == $divisi->id ? 'selected' : '' }}>
                {{ $divisi->nama_divisi }}
            </option>
        @endforeach
    </select>
</div>

<div class="mt-6">
    <label for="file_surat" class="block text-sm font-medium text-gray-700">Upload File Surat (PDF, DOCX, JPG)</label>
    <input type="file" id="file_surat" name="file_surat"
        class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-l-lg file:border-0
                  file:text-sm file:font-semibold
                  file:bg-indigo-50 file:text-indigo-700
                  hover:file:bg-indigo-100">
    @if (isset($surat) && $surat->file_path)
        <p class="mt-2 text-sm text-gray-500">
            File saat ini: <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                class="font-medium text-indigo-600 hover:text-indigo-900">Lihat File</a>
        </p>
        <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah file.</p>
    @endif
</div>

<div class="mt-6">
    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
    <textarea id="keterangan" name="keterangan" rows="4"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('keterangan', $surat->keterangan ?? '') }}</textarea>
</div>

<div class="flex items-center justify-end mt-8 gap-4">
    <a href="{{ route('surat.index') }}"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
        Batal
    </a>

    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
        {{ isset($surat) ? 'Update Data' : 'Simpan Data' }}
    </button>
</div>
