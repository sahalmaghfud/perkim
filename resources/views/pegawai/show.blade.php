@extends('layouts.app')

{{-- Menambahkan style khusus untuk animasi modal agar lebih halus --}}
@push('styles')
    <style>
        #document-modal {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        #modal-content {
            transform: scale(0.95);
            transition: all 0.3s ease-in-out;
        }

        /* Style untuk hover pada icon di detail list */
        .detail-item-icon {
            color: #6B7280;
            /* text-gray-500 default */
            transition: color 0.2s ease-in-out;
        }

        .detail-item:hover .detail-item-icon {
            color: #FBBF24;
            /* text-yellow-500 on hover */
        }
    </style>
@endpush


@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-gradient-midnight-green text-white rounded-2xl shadow-xl p-6 md:p-8 overflow-hidden mb-8">
            <i
                class="fas fa-user-tie absolute -right-8 -bottom-12 text-midnight_green-400/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ $pegawai->nama }}</h1>
                    <p class="mt-1 text-midnight_green-900/80">Detail informasi dan dokumen kepegawaian.</p>
                </div>
                <a href="{{ route('pegawai.index') }}"
                    class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-ecru-900/60 border border-transparent rounded-lg font-semibold text-xs text-midnight_green-100 uppercase tracking-widest hover:bg-ecru-900/80 transition-all ease-in-out duration-150 whitespace-nowrap shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Detail Informasi Pegawai --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Kartu Profil Utama --}}
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0 p-6 flex items-center justify-center">
                            <img class="h-40 w-40 rounded-full object-cover ring-4 ring-offset-4 ring-offset-white/70 ring-ecru"
                                src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://placehold.co/192x192/e2e8f0/718096?text=Foto' }}"
                                alt="Foto {{ $pegawai->nama }}">
                        </div>
                        <div class="p-6 flex flex-col justify-center">
                            <div class="uppercase tracking-wide text-sm text-ecru-300 font-bold">
                                {{ $pegawai->nama_jabatan ?? 'Jabatan Belum Diatur' }}
                            </div>
                            <h2 class="block mt-1 text-3xl leading-tight font-extrabold text-midnight_green">
                                {{ $pegawai->nama }}
                            </h2>
                            <p class="mt-2 text-midnight_green-400">NIP: {{ $pegawai->nip }}</p>
                            <p class="mt-1 text-midnight_green-400">Bidang: {{ $pegawai->bidang->nama_bidang }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kartu Detail Tambahan --}}
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl overflow-hidden p-6 md:p-8">
                    <h3 class="text-xl font-bold text-midnight_green mb-6 pb-3 border-b border-midnight_green/10">Data
                        Kepegawaian</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-id-badge mr-2 detail-item-icon"></i>Pangkat/Golongan
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->pangkat->pangkat }}
                                ({{ $pegawai->pangkat->golongan }}/{{ $pegawai->pangkat->ruang }})
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-user-tag mr-2 detail-item-icon"></i>Eselon
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->eselon ?? '-' }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-calendar-alt mr-2 detail-item-icon"></i>TMT CPNS
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ \Carbon\Carbon::parse($pegawai->tmt_cpns)->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-calendar-check mr-2 detail-item-icon"></i>TMT Pangkat
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ \Carbon\Carbon::parse($pegawai->tmt_pangkat)->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-calendar-days mr-2 detail-item-icon"></i>TMT Jabatan
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->tmt_jabatan ? \Carbon\Carbon::parse($pegawai->tmt_jabatan)->isoFormat('D MMMM Y') : '-' }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-venus-mars mr-2 detail-item-icon"></i>Jenis Kelamin
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-cake-candles mr-2 detail-item-icon"></i>Tempat, Tanggal Lahir
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->isoFormat('D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-hourglass-half mr-2 detail-item-icon"></i>Usia
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">{{ $pegawai->usia }} Tahun
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Kartu Pendidikan --}}
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl overflow-hidden p-6 md:p-8">
                    <h3 class="text-xl font-bold text-midnight_green mb-6 pb-3 border-b border-midnight_green/10">Riwayat
                        Pendidikan</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-book-open mr-2 detail-item-icon"></i>Pendidikan Terakhir
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->pendidikan_terakhir }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-university mr-2 detail-item-icon"></i>Jurusan
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->jurusan }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-calendar-day mr-2 detail-item-icon"></i>Tahun Lulus
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->tahun_lulus }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-chalkboard-teacher mr-2 detail-item-icon"></i>Pendidikan
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->pendidikan }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Kartu Diklat --}}
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl overflow-hidden p-6 md:p-8">
                    <h3 class="text-xl font-bold text-midnight_green mb-6 pb-3 border-b border-midnight_green/10">Riwayat
                        Diklat</h3>
                    @if ($pegawai->nama_diklat || $pegawai->tahun_diklat || $pegawai->jumlah_jam_diklat)
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                            <div class="flex flex-col detail-item">
                                <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                    <i class="fas fa-certificate mr-2 detail-item-icon"></i>Nama Diklat
                                </dt>
                                <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                    {{ $pegawai->nama_diklat ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex flex-col detail-item">
                                <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                    <i class="fas fa-calendar mr-2 detail-item-icon"></i>Tahun Diklat
                                </dt>
                                <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                    {{ $pegawai->tahun_diklat ?? '-' }}
                                </dd>
                            </div>
                            <div class="flex flex-col detail-item">
                                <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                    <i class="fas fa-clock mr-2 detail-item-icon"></i>Jumlah Jam
                                </dt>
                                <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                    {{ $pegawai->jumlah_jam_diklat ? $pegawai->jumlah_jam_diklat . ' Jam' : '-' }}
                                </dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-midnight_green-300 italic text-center py-4">Tidak ada riwayat diklat.</p>
                    @endif
                </div>

                {{-- Kartu Keterangan & Catatan Mutasi --}}
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl overflow-hidden p-6 md:p-8">
                    <h3 class="text-xl font-bold text-midnight_green mb-6 pb-3 border-b border-midnight_green/10">Catatan
                        Lainnya</h3>
                    <dl class="grid grid-cols-1 gap-x-8 gap-y-6">
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-info-circle mr-2 detail-item-icon"></i>Keterangan
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->keterangan ?? '-' }}
                            </dd>
                        </div>
                        <div class="flex flex-col detail-item">
                            <dt class="text-sm font-medium text-midnight_green-300 flex items-center">
                                <i class="fas fa-history mr-2 detail-item-icon"></i>Catatan Mutasi
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-midnight_green-200">
                                {{ $pegawai->catatan_mutasi ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Kolom Kanan: Dokumen Terkait --}}
            <div class="lg:col-span-1">
                <div class="bg-white/70 backdrop-blur-md shadow-lg rounded-2xl">
                    <div class="p-6 border-b border-midnight_green/10">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-midnight_green">Dokumen Terkait</h3>
                            <button id="add-document-btn" title="Tambah Dokumen"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-midnight_green text-white shadow-md transition duration-300 ease-in-out transform hover:bg-midnight_green-600 hover:scale-110">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        @if ($pegawai->dokumenPegawai->count() > 0)
                            <ul class="divide-y divide-midnight_green/10">
                                @foreach ($pegawai->dokumenPegawai as $dokumen)
                                    <li
                                        class="p-4 flex items-center justify-between hover:bg-ecru-900/60 transition-colors duration-200 group">
                                        <div class="flex items-center space-x-4">
                                            <i class="fas fa-file-alt text-ecru-300 group-hover:text-ecru-400"></i>
                                            <div class="flex-grow">
                                                <p
                                                    class="text-sm font-medium text-midnight_green-200 group-hover:text-midnight_green-100">
                                                    {{ $dokumen->judul }}</p>
                                                <p
                                                    class="text-xs text-midnight_green-300 group-hover:text-midnight_green-200">
                                                    {{ $dokumen->jenis_dokumen }}</p>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank"
                                                class="text-midnight_green-300 hover:text-ecru-400" title="Lihat Dokumen">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('pegawai.dokumen.destroy', $dokumen->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus dokumen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-midnight_green-300 hover:text-red-500"
                                                    title="Hapus Dokumen">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-12 px-6">
                                <i class="fas fa-folder-open text-4xl text-midnight_green/20 mb-4"></i>
                                <p class="text-sm font-medium text-midnight_green-300">Belum Ada Dokumen</p>
                                <p class="mt-1 text-xs text-midnight_green-400">Klik tombol '+' untuk menambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Tambah Dokumen (dengan gaya yang disesuaikan) --}}
    {{-- Modal Tambah Dokumen (dengan gaya yang disesuaikan) --}}
    <div id="document-modal"
        class="fixed inset-0 bg-black/70 flex items-center justify-center hidden z-50 p-4 transition-opacity duration-300">

        <div class="bg-ecru-900 rounded-2xl shadow-xl w-full max-w-md transform transition-all duration-300 scale-95"
            id="modal-content">

            <div class="flex justify-between items-center p-6 border-b border-midnight_green/20">
                <h3 class="text-xl font-bold text-midnight_green-200">Unggah Dokumen Baru</h3>
                <button id="close-modal-btn" aria-label="Close"
                    class="text-midnight_green-300 hover:text-white transition rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-ecru-500">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" method="POST"
                enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-5">

                    <div>
                        <label for="judul" class="block text-sm font-medium text-midnight_green-300 mb-1">Judul
                            Dokumen</label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                            autofocus
                            class="block w-full bg-white/10 text-white border border-midnight_green/30 rounded-lg shadow-sm focus:border-ecru-500 focus:ring-ecru-500 sm:text-sm py-2 px-3 @error('judul') border-red-500 @enderror">
                        @error('judul')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bagian Jenis Dokumen Diperbarui --}}
                    <div>
                        <label for="jenis_dokumen" class="block text-sm font-medium text-midnight_green-300 mb-1">Jenis
                            Dokumen</label>
                        {{-- Style diubah agar teks menjadi hitam dengan background putih --}}
                        <select name="jenis_dokumen" id="jenis_dokumen" required
                            class="block w-full bg-white text-gray-900 border border-midnight_green/30 rounded-lg shadow-sm focus:border-ecru-500 focus:ring-ecru-500 sm:text-sm py-2 px-3 @error('jenis_dokumen') border-red-500 @enderror">
                            <option value="" disabled selected>Pilih Jenis Dokumen</option>
                            <option value="SK CPNS" {{ old('jenis_dokumen') == 'SK CPNS' ? 'selected' : '' }}>SK CPNS
                            </option>
                            <option value="SK PNS" {{ old('jenis_dokumen') == 'SK PNS' ? 'selected' : '' }}>SK PNS
                            </option>
                            <option value="SK Kenaikan Pangkat"
                                {{ old('jenis_dokumen') == 'SK Kenaikan Pangkat' ? 'selected' : '' }}>SK Kenaikan Pangkat
                            </option>
                            <option value="Ijazah" {{ old('jenis_dokumen') == 'Ijazah' ? 'selected' : '' }}>Ijazah
                            </option>
                            <option value="Sertifikat Pelatihan/Diklat"
                                {{ old('jenis_dokumen') == 'Sertifikat Pelatihan/Diklat' ? 'selected' : '' }}>Sertifikat
                                Pelatihan/Diklat</option>
                            <option value="KTP" {{ old('jenis_dokumen') == 'KTP' ? 'selected' : '' }}>KTP</option>
                            <option value="KK" {{ old('jenis_dokumen') == 'KK' ? 'selected' : '' }}>KK</option>
                            <option value="Lainnya" {{ old('jenis_dokumen') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                        @error('jenis_dokumen')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror

                        {{-- Input field ini akan muncul saat "Lainnya" dipilih --}}
                        <div id="jenis_dokumen_lainnya_container"
                            class="mt-3 {{ old('jenis_dokumen') == 'Lainnya' ? '' : 'hidden' }}">
                            <label for="jenis_dokumen_lainnya_input"
                                class="block text-sm font-medium text-midnight_green-300 mb-1">Jenis Dokumen
                                Lainnya</label>
                            <input type="text" name="jenis_dokumen_lainnya" id="jenis_dokumen_lainnya_input"
                                value="{{ old('jenis_dokumen_lainnya') }}" placeholder="Ketikkan jenis dokumen di sini"
                                class="block w-full bg-white text-gray-900 border border-midnight_green/30 rounded-lg shadow-sm focus:border-ecru-500 focus:ring-ecru-500 sm:text-sm py-2 px-3 @error('jenis_dokumen_lainnya') border-red-500 @enderror">
                            @error('jenis_dokumen_lainnya')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-medium text-midnight_green-300 mb-1">Pilih
                            File</label>
                        <div class="relative mt-1">
                            <input type="file" name="file" id="file" required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                aria-describedby="file-name">
                            <div
                                class="flex items-center justify-between w-full text-sm text-midnight_green-300 border border-midnight_green/30 rounded-lg px-3 py-2 @error('file') border-red-500 @enderror">
                                <span id="file-name" class="text-gray-400 truncate">Belum ada file yang dipilih...</span>
                                <span
                                    class="font-semibold bg-ecru-500/20 text-ecru-300 hover:bg-ecru-500/30 py-1 px-3 rounded-full text-xs">
                                    Telusuri
                                </span>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" id="cancel-btn"
                        class="bg-midnight_green/30 hover:bg-midnight_green/50 text-white font-bold py-2 px-5 rounded-lg shadow-sm transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-ecru-500 hover:bg-ecru-600 text-midnight_green-100 font-bold py-2 px-5 rounded-lg shadow-sm transition">
                        Simpan Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen-elemen untuk fungsionalitas modal
            const modal = document.getElementById('document-modal');
            const modalContent = document.getElementById('modal-content');
            const addBtn = document.getElementById('add-document-btn');
            const closeBtn = document.getElementById('close-modal-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const form = document.querySelector('#document-modal form');

            // Elemen-elemen baru untuk dropdown "Jenis Dokumen"
            const jenisDokumenSelect = document.getElementById('jenis_dokumen');
            const lainnyaContainer = document.getElementById('jenis_dokumen_lainnya_container');
            const lainnyaInput = document.getElementById('jenis_dokumen_lainnya_input');

            function showModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 10);
            }

            function hideModal() {
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    form.reset(); // Mereset form
                    // Memastikan field "Lainnya" juga ikut tersembunyi saat modal ditutup
                    lainnyaContainer.classList.add('hidden');
                    lainnyaInput.removeAttribute('required');
                }, 300);
            }

            // Event listener untuk tombol-tombol modal
            addBtn.addEventListener('click', showModal);
            closeBtn.addEventListener('click', hideModal);
            cancelBtn.addEventListener('click', hideModal);
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    hideModal();
                }
            });
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    hideModal();
                }
            });

            // === Fungsionalitas Baru untuk Opsi "Lainnya" ===
            jenisDokumenSelect.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    lainnyaContainer.classList.remove('hidden'); // Tampilkan input
                    lainnyaInput.setAttribute('required', 'required'); // Jadikan wajib diisi
                } else {
                    lainnyaContainer.classList.add('hidden'); // Sembunyikan input
                    lainnyaInput.removeAttribute('required'); // Hapus atribut wajib
                    lainnyaInput.value = ''; // Kosongkan nilainya
                }
            });

            // Trigger check saat halaman dimuat (jika ada old value dari server)
            if (jenisDokumenSelect.value === 'Lainnya') {
                lainnyaContainer.classList.remove('hidden');
                lainnyaInput.setAttribute('required', 'required');
            }
        });
    </script>
@endpush
