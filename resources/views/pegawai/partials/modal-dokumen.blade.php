{{-- Modal Tambah Dokumen (dengan gaya hijau-putih) --}}
<div id="document-modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 p-4 transition-opacity duration-300">

    <div id="modal-content"
        class="w-full max-w-md transform rounded-2xl bg-white shadow-xl transition-all duration-300 scale-95">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between border-b border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800">Unggah Dokumen Baru</h3>
            <button id="close-modal-btn" aria-label="Close"
                class="rounded-full p-1 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Form Modal --}}
        <form action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" method="POST" enctype="multipart/form-data"
            class="p-6">
            @csrf
            <div class="space-y-5">

                {{-- Input Judul Dokumen --}}
                <div>
                    <label for="judul" class="mb-1 block text-sm font-medium text-gray-700">Judul Dokumen</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required autofocus
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('judul') border-red-500 @enderror">
                    @error('judul')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Jenis Dokumen --}}
                <div>
                    <label for="jenis_dokumen" class="mb-1 block text-sm font-medium text-gray-700">Jenis
                        Dokumen</label>
                    <select name="jenis_dokumen" id="jenis_dokumen" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('jenis_dokumen') border-red-500 @enderror">
                        <option value="" disabled selected>Pilih Jenis Dokumen</option>
                        <option value="SK CPNS" {{ old('jenis_dokumen') == 'SK CPNS' ? 'selected' : '' }}>SK CPNS
                        </option>
                        <option value="SK PNS" {{ old('jenis_dokumen') == 'SK PNS' ? 'selected' : '' }}>SK PNS</option>
                        <option value="SK Kenaikan Pangkat"
                            {{ old('jenis_dokumen') == 'SK Kenaikan Pangkat' ? 'selected' : '' }}>SK Kenaikan Pangkat
                        </option>
                        <option value="Ijazah" {{ old('jenis_dokumen') == 'Ijazah' ? 'selected' : '' }}>Ijazah</option>
                        <option value="Sertifikat Pelatihan/Diklat"
                            {{ old('jenis_dokumen') == 'Sertifikat Pelatihan/Diklat' ? 'selected' : '' }}>Sertifikat
                            Pelatihan/Diklat</option>
                        <option value="KTP" {{ old('jenis_dokumen') == 'KTP' ? 'selected' : '' }}>KTP</option>
                        <option value="KK" {{ old('jenis_dokumen') == 'KK' ? 'selected' : '' }}>KK</option>
                        <option value="Lainnya" {{ old('jenis_dokumen') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                        </option>
                    </select>
                    @error('jenis_dokumen')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    {{-- Input field ini akan muncul saat "Lainnya" dipilih --}}
                    <div id="jenis_dokumen_lainnya_container"
                        class="mt-3 {{ old('jenis_dokumen') == 'Lainnya' ? '' : 'hidden' }}">
                        <label for="jenis_dokumen_lainnya_input"
                            class="mb-1 block text-sm font-medium text-gray-700">Jenis Dokumen Lainnya</label>
                        <input type="text" name="jenis_dokumen_lainnya" id="jenis_dokumen_lainnya_input"
                            value="{{ old('jenis_dokumen_lainnya') }}" placeholder="Ketikkan jenis dokumen di sini"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm @error('jenis_dokumen_lainnya') border-red-500 @enderror">
                        @error('jenis_dokumen_lainnya')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Input File --}}
                <div>
                    <label for="file" class="mb-1 block text-sm font-medium text-gray-700">Pilih File</label>
                    <div class="relative mt-1">
                        <input type="file" name="file" id="file" required
                            class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                            aria-describedby="file-name">
                        <div
                            class="flex w-full items-center justify-between rounded-lg border border-gray-300 px-3 py-2 text-sm @error('file') border-red-500 @enderror">
                            <span id="file-name" class="truncate text-gray-500">Belum ada file yang dipilih...</span>
                            <span
                                class="rounded-md bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">Telusuri</span>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" id="cancel-btn"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2 font-bold text-gray-800 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-lg bg-green-600 px-5 py-2 font-bold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
