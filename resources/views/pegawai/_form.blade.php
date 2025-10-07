{{--
    File _form.blade.php ini berisi semua input field untuk data pegawai.
    Dibuat untuk di-include oleh create.blade.php dan edit.blade.php.
    Variabel $pegawai bersifat opsional untuk menangani kasus 'create'.
--}}


{{-- Notifikasi Error Validasi --}}
@if ($errors->any())
    <div class="bg-red-500/10 border-l-4 border-red-500 text-red-200 p-4 mb-8 rounded-lg" role="alert">
        <p class="font-bold text-red-100">Oops! Ada yang salah dengan input Anda.</p>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- KARTU UTAMA FORM --}}
<div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl p-6 md:p-8 space-y-10">

    {{-- =================================== --}}
    {{-- GRUP 1: INFORMASI PRIBADI --}}
    {{-- =================================== --}}
    <div>
        <h3 class="text-lg font-semibold text-midnight_green border-b border-midnight_green/10 pb-3 mb-6">
            <i class="fas fa-user-circle mr-2 text-ecru-300"></i>
            Informasi Pribadi
        </h3>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-midnight_green-300">Nama Lengkap <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pegawai->nama ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        required>
                </div>
                <div>
                    <label for="nip" class="block text-sm font-medium text-midnight_green-300">NIP <span
                            class="text-red-400">*</span></label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-midnight_green-300">Jenis
                        Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                        <option value="L"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="P"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-midnight_green-300">Tempat
                        Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-midnight_green-300">Tanggal
                        Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
            </div>
        </div>
    </div>

    {{-- =================================== --}}
    {{-- GRUP 2: DATA KEPEGAWAIAN --}}
    {{-- =================================== --}}
    <div>
        <h3 class="text-lg font-semibold text-midnight_green border-b border-midnight_green/10 pb-3 mb-6">
            <i class="fas fa-briefcase mr-2 text-ecru-300"></i>
            Data Kepegawaian
        </h3>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bidang_id" class="block text-sm font-medium text-midnight_green-300">Bidang <span
                            class="text-red-400">*</span></label>
                    <select name="bidang_id" id="bidang_id"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        required>
                        @foreach ($bidangs as $bidang)
                            <option value="{{ $bidang->id }}"
                                {{ old('bidang_id', $pegawai->bidang_id ?? '') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama_bidang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="pangkat_id" class="block text-sm font-medium text-midnight_green-300">Pangkat / Golongan
                        <span class="text-red-400">*</span></label>
                    <select name="pangkat_id" id="pangkat_id"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        required>
                        @foreach ($pangkats as $pangkat)
                            <option value="{{ $pangkat->id }}"
                                {{ old('pangkat_id', $pegawai->pangkat_id ?? '') == $pangkat->id ? 'selected' : '' }}>
                                {{ $pangkat->pangkat }} ({{ $pangkat->golongan }}/{{ $pangkat->ruang }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tmt_cpns" class="block text-sm font-medium text-midnight_green-300">TMT CPNS</label>
                    <input type="date" name="tmt_cpns" id="tmt_cpns"
                        value="{{ old('tmt_cpns', $pegawai->tmt_cpns ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="tmt_pangkat" class="block text-sm font-medium text-midnight_green-300">TMT Pangkat
                        Terakhir</label>
                    <input type="date" name="tmt_pangkat" id="tmt_pangkat"
                        value="{{ old('tmt_pangkat', $pegawai->tmt_pangkat ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_jabatan" class="block text-sm font-medium text-midnight_green-300">Nama
                        Jabatan</label>
                    <input type="text" name="nama_jabatan" id="nama_jabatan"
                        value="{{ old('nama_jabatan', $pegawai->nama_jabatan ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="eselon" class="block text-sm font-medium text-midnight_green-300">Eselon</label>
                    <input type="text" name="eselon" id="eselon"
                        value="{{ old('eselon', $pegawai->eselon ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
            </div>
            <div>
                <label for="tmt_jabatan" class="block text-sm font-medium text-midnight_green-300">TMT Jabatan</label>
                <input type="date" name="tmt_jabatan" id="tmt_jabatan"
                    value="{{ old('tmt_jabatan', $pegawai->tmt_jabatan ?? '') }}"
                    class="mt-1 block w-full md:w-1/2 bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
            </div>
        </div>
    </div>

    {{-- =================================== --}}
    {{-- GRUP 3: PENDIDIKAN & PELATIHAN --}}
    {{-- =================================== --}}
    <div>
        <h3 class="text-lg font-semibold text-midnight_green border-b border-midnight_green/10 pb-3 mb-6">
            <i class="fas fa-graduation-cap mr-2 text-ecru-300"></i>
            Pendidikan & Pelatihan
        </h3>
        <div class="space-y-6">
            {{-- Bagian Pendidikan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pendidikan_terakhir" class="block text-sm font-medium text-midnight_green-300">Tingkat
                        Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">

                        <option value="" disabled selected>Pilih Pendidikan</option>

                        @php
                            $pendidikanOptions = ['SD', 'SLTP', 'SLTA', 'D1', 'D2', 'D3', 'D4 ', 'S1', 'S2', 'S3'];

                            $selectedValue = old('pendidikan_terakhir', $pegawai->pendidikan_terakhir ?? '');
                        @endphp

                        @foreach ($pendidikanOptions as $option)
                            <option value="{{ $option }}" {{ $selectedValue == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach

                    </select>
                </div>
                <div>
                    <label for="jurusan" class="block text-sm font-medium text-midnight_green-300">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan"
                        value="{{ old('jurusan', $pegawai->jurusan ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="nama_univ" class="block text-sm font-medium text-midnight_green-300">Nama Universitas
                        / Perguruan Tinggi</label>
                    <input type="text" name="nama_univ" id="nama_univ"
                        value="{{ old('nama_univ', $pegawai->nama_univ ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="tahun_lulus" class="block text-sm font-medium text-midnight_green-300">Tahun
                        Lulus</label>
                    <input type="number" name="tahun_lulus" id="tahun_lulus"
                        value="{{ old('tahun_lulus', $pegawai->tahun_lulus ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        placeholder="YYYY">
                </div>
            </div>

            {{-- Bagian Diklat --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="nama_diklat" class="block text-sm font-medium text-midnight_green-300">Nama
                        Diklat</label>
                    <input type="text" name="nama_diklat" id="nama_diklat"
                        value="{{ old('nama_diklat', $pegawai->nama_diklat ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
                <div>
                    <label for="tahun_diklat" class="block text-sm font-medium text-midnight_green-300">Tahun
                        Diklat</label>
                    <input type="number" name="tahun_diklat" id="tahun_diklat"
                        value="{{ old('tahun_diklat', $pegawai->tahun_diklat ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3"
                        placeholder="YYYY">
                </div>
                <div>
                    <label for="jumlah_jam_diklat" class="block text-sm font-medium text-midnight_green-300">Jumlah
                        Jam</label>
                    <input type="number" name="jumlah_jam_diklat" id="jumlah_jam_diklat"
                        value="{{ old('jumlah_jam_diklat', $pegawai->jumlah_jam_diklat ?? '') }}"
                        class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold text-midnight_green border-b border-midnight_green/10 pb-3 mb-6">
            <i class="fas fa-paperclip mr-2 text-ecru-300"></i>
            Lampiran & Catatan
        </h3>
        <div class="space-y-6">
            <div>
                <label for="foto" class="block text-sm font-medium text-midnight_green-300">Foto Pegawai</label>
                <input type="file" name="foto" id="foto"
                    class="mt-1 block w-full text-sm text-midnight_green-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ecru-500/20 file:text-ecru-300 hover:file:bg-ecru-500/30 cursor-pointer">
                @if (isset($pegawai) && $pegawai->foto)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai"
                            class="h-24 w-24 object-cover rounded-lg shadow-md">
                        <small class="text-xs text-midnight_green-400">Foto saat ini. Upload file baru untuk
                            mengganti.</small>
                    </div>
                @endif
            </div>
            <div>
                <label for="keterangan" class="block text-sm font-medium text-midnight_green-300">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">{{ old('keterangan', $pegawai->keterangan ?? '') }}</textarea>
            </div>
            <div>
                <label for="catatan_mutasi" class="block text-sm font-medium text-midnight_green-300">Catatan
                    Mutasi</label>
                <textarea name="catatan_mutasi" id="catatan_mutasi" rows="3"
                    class="mt-1 block w-full bg-white/60 text-midnight_green border border-midnight_green/20 rounded-lg shadow-sm focus:border-ecru focus:ring-ecru sm:text-sm py-2 px-3">{{ old('catatan_mutasi', $pegawai->catatan_mutasi ?? '') }}</textarea>
            </div>
        </div>
    </div>

</div>
