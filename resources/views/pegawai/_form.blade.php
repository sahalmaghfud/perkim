@csrf
<div class="space-y-6">
    <!-- Baris 1: Nama & NIP -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $pegawai->nama ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('nip')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 2: Tempat Lahir & Tanggal Lahir -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir"
                value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('tempat_lahir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('tanggal_lahir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 3: Bidang & Pangkat -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="bidang_id" class="block text-sm font-medium text-gray-700">Bidang</label>
            <select name="bidang_id" id="bidang_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
                @foreach ($bidangs as $bidang)
                    <option value="{{ $bidang->id }}"
                        {{ old('bidang_id', $pegawai->bidang_id ?? '') == $bidang->id ? 'selected' : '' }}>
                        {{ $bidang->nama_bidang }}
                    </option>
                @endforeach
            </select>
            @error('bidang_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="pangkat_id" class="block text-sm font-medium text-gray-700">Pangkat / Golongan</label>
            <select name="pangkat_id" id="pangkat_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
                @foreach ($pangkats as $pangkat)
                    <option value="{{ $pangkat->id }}"
                        {{ old('pangkat_id', $pegawai->pangkat_id ?? '') == $pangkat->id ? 'selected' : '' }}>
                        {{ $pangkat->pangkat }} ({{ $pangkat->golongan }}/{{ $pangkat->ruang }})
                    </option>
                @endforeach
            </select>
            @error('pangkat_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 4: TMT CPNS & TMT Pangkat -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tmt_cpns" class="block text-sm font-medium text-gray-700">TMT CPNS</label>
            <input type="date" name="tmt_cpns" id="tmt_cpns"
                value="{{ old('tmt_cpns', $pegawai->tmt_cpns ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('tmt_cpns')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tmt_pangkat" class="block text-sm font-medium text-gray-700">TMT Pangkat Terakhir</label>
            <input type="date" name="tmt_pangkat" id="tmt_pangkat"
                value="{{ old('tmt_pangkat', $pegawai->tmt_pangkat ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('tmt_pangkat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 5: Jabatan & Eselon & TMT Jabatan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" id="nama_jabatan"
                value="{{ old('nama_jabatan', $pegawai->nama_jabatan ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="eselon" class="block text-sm font-medium text-gray-700">Eselon</label>
            <input type="text" name="eselon" id="eselon" value="{{ old('eselon', $pegawai->eselon ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="tmt_jabatan" class="block text-sm font-medium text-gray-700">TMT Jabatan</label>
            <input type="date" name="tmt_jabatan" id="tmt_jabatan"
                value="{{ old('tmt_jabatan', $pegawai->tmt_jabatan ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
    </div>

    <!-- Baris 6: Pendidikan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir"
                value="{{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
        </div>
        <div>
            <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan"
                value="{{ old('jurusan', $pegawai->jurusan ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
        </div>
        <div>
            <label for="tahun_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
            <input type="number" name="tahun_lulus" id="tahun_lulus" min="1950" max="{{ date('Y') }}"
                value="{{ old('tahun_lulus', $pegawai->tahun_lulus ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
        </div>
    </div>

    <!-- Baris 7: Riwayat Diklat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="nama_diklat" class="block text-sm font-medium text-gray-700">Nama Diklat</label>
            <input type="text" name="nama_diklat" id="nama_diklat"
                value="{{ old('nama_diklat', $pegawai->nama_diklat ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="tahun_diklat" class="block text-sm font-medium text-gray-700">Tahun Diklat</label>
            <input type="number" name="tahun_diklat" id="tahun_diklat" min="1950" max="{{ date('Y') }}"
                value="{{ old('tahun_diklat', $pegawai->tahun_diklat ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="jumlah_jam_diklat" class="block text-sm font-medium text-gray-700">Jumlah Jam</label>
            <input type="number" name="jumlah_jam_diklat" id="jumlah_jam_diklat" min="0"
                value="{{ old('jumlah_jam_diklat', $pegawai->jumlah_jam_diklat ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
    </div>

    <!-- Baris 8: Jenis Kelamin & Foto -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
                <option value="L"
                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
                </option>
                <option value="P"
                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan
                </option>
            </select>
        </div>
        <div>
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
            <input type="file" name="foto" id="foto"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @if (isset($pegawai) && $pegawai->foto)
                <div class="mt-2">
                    <img src="{{ Storage::url($pegawai->foto) }}" alt="Foto Pegawai"
                        class="h-20 w-20 object-cover rounded-md">
                </div>
            @endif
        </div>
    </div>

    <!-- Catatan Mutasi -->
    <div>
        <label for="catatan_mutasi" class="block text-sm font-medium text-gray-700">Catatan Mutasi</label>
        <textarea name="catatan_mutasi" id="catatan_mutasi" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('catatan_mutasi', $pegawai->catatan_mutasi ?? '') }}</textarea>
    </div>

    <!-- Keterangan -->
    <div>
        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
        <textarea name="keterangan" id="keterangan" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('keterangan', $pegawai->keterangan ?? '') }}</textarea>
    </div>

</div>

<div class="flex justify-end pt-8">
    <a href="{{ route('pegawai.index') }}"
        class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Batal
    </a>
    <button type="submit"
        class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
</div>
