@csrf
<div class="space-y-6">
    <!-- Baris 1: Nama & NIP -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $pegawai->nama ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('nip')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 2: Jenis Kelamin, Tempat & Tanggal Lahir -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
                <option value="L"
                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
                </option>
                <option value="P"
                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan
                </option>
            </select>
            @error('jenis_kelamin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir"
                value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('tempat_lahir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
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
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
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
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
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
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('tmt_cpns')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tmt_pangkat" class="block text-sm font-medium text-gray-700">TMT Pangkat Terakhir</label>
            <input type="date" name="tmt_pangkat" id="tmt_pangkat"
                value="{{ old('tmt_pangkat', $pegawai->tmt_pangkat ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('tmt_pangkat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 5: Jabatan & Eselon -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" id="nama_jabatan"
                value="{{ old('nama_jabatan', $pegawai->nama_jabatan ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('nama_jabatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="eselon" class="block text-sm font-medium text-gray-700">Eselon</label>
            <input type="text" name="eselon" id="eselon" value="{{ old('eselon', $pegawai->eselon ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('eselon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 6: TMT Jabatan & Foto -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tmt_jabatan" class="block text-sm font-medium text-gray-700">TMT Jabatan</label>
            <input type="date" name="tmt_jabatan" id="tmt_jabatan"
                value="{{ old('tmt_jabatan', $pegawai->tmt_jabatan ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('tmt_jabatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
            <input type="file" name="foto" id="foto"
                class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white focus:border-indigo-500 focus:ring-indigo-500">
            @if ($pegawai->foto)
                <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai" class="mt-2 h-24 rounded">
            @endif
            @error('foto')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 7: Pendidikan & Jurusan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
            <input type="text" name="pendidikan" id="pendidikan"
                value="{{ old('pendidikan', $pegawai->pendidikan ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('pendidikan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan"
                value="{{ old('jurusan', $pegawai->jurusan ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4"
                required>
            @error('jurusan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 8: Pendidikan Terakhir & Tahun Lulus -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan
                Terakhir</label>
            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir"
                value="{{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('pendidikan_terakhir')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tahun_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
            <input type="number" name="tahun_lulus" id="tahun_lulus"
                value="{{ old('tahun_lulus', $pegawai->tahun_lulus ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('tahun_lulus')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 9: Diklat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="nama_diklat" class="block text-sm font-medium text-gray-700">Nama Diklat</label>
            <input type="text" name="nama_diklat" id="nama_diklat"
                value="{{ old('nama_diklat', $pegawai->nama_diklat ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('nama_diklat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tahun_diklat" class="block text-sm font-medium text-gray-700">Tahun Diklat</label>
            <input type="number" name="tahun_diklat" id="tahun_diklat"
                value="{{ old('tahun_diklat', $pegawai->tahun_diklat ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('tahun_diklat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="jumlah_jam_diklat" class="block text-sm font-medium text-gray-700">Jumlah Jam Diklat</label>
            <input type="number" name="jumlah_jam_diklat" id="jumlah_jam_diklat"
                value="{{ old('jumlah_jam_diklat', $pegawai->jumlah_jam_diklat ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">
            @error('jumlah_jam_diklat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Baris 10: Keterangan & Catatan Mutasi -->
    <div>
        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
        <textarea name="keterangan" id="keterangan" rows="3"
            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">{{ old('keterangan', $pegawai->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="catatan_mutasi" class="block text-sm font-medium text-gray-700">Catatan Mutasi</label>
        <textarea name="catatan_mutasi" id="catatan_mutasi" rows="3"
            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base py-3 px-4">{{ old('catatan_mutasi', $pegawai->catatan_mutasi ?? '') }}</textarea>
        @error('catatan_mutasi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
