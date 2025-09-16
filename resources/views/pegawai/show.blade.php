@extends('layouts.app') {{-- Pastikan ini sesuai dengan layout utama Anda --}}

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Pegawai</h1>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap dan dokumen terkait untuk {{ $pegawai->nama }}.</p>
            </div>
            <a href="{{ route('pegawai.index') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                &larr; &nbsp; Kembali ke Daftar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Detail Informasi Pegawai --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0 p-8 bg-gray-50 flex items-center justify-center">
                            <img class="h-40 w-40 rounded-full object-cover ring-4 ring-indigo-200"
                                src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://placehold.co/192x192/e2e8f0/718096?text=Foto' }}"
                                alt="Foto {{ $pegawai->nama }}">
                        </div>
                        <div class="p-8 flex-grow">
                            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                                {{ $pegawai->nama_jabatan ?? 'Jabatan Belum Diatur' }}</div>
                            <h2 class="block mt-1 text-3xl leading-tight font-extrabold text-gray-900">{{ $pegawai->nama }}
                            </h2>
                            <p class="mt-2 text-gray-600">NIP: {{ $pegawai->nip }}</p>
                        </div>
                    </div>

                    {{-- Detail Tambahan --}}
                    <div class="border-t border-gray-200 px-8 py-6">
                        <dl class="divide-y divide-gray-200">
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Pangkat/Golongan</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $pegawai->pangkat->pangkat }}
                                    ({{ $pegawai->pangkat->golongan }}/{{ $pegawai->pangkat->ruang }})</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Bidang</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $pegawai->bidang->nama_bidang }}</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">TMT CPNS</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($pegawai->tmt_cpns)->isoFormat('D MMMM Y') }}</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">TMT Pangkat</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($pegawai->tmt_pangkat)->isoFormat('D MMMM Y') }}</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Pendidikan Terakhir</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $pegawai->pendidikan_terakhir }} - {{ $pegawai->jurusan }}
                                    ({{ $pegawai->tahun_lulus }})</dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Usia</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pegawai->usia }} Tahun
                                </dd>
                            </div>
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $pegawai->keterangan ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Dokumen Terkait --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-lg rounded-xl">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900">Dokumen Terkait</h3>
                            <button id="add-document-btn"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition duration-300 ease-in-out transform hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        @if ($pegawai->dokumenPegawai->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach ($pegawai->dokumenPegawai as $dokumen)
                                    <li
                                        class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-center space-x-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div class="flex-grow">
                                                <p class="text-sm font-medium text-gray-900">{{ $dokumen->judul }}</p>
                                                <p class="text-xs text-gray-500">{{ $dokumen->jenis_dokumen }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            {{-- Pastikan nama route ini benar, contoh: 'dokumen.show' atau 'pegawai.dokumen.show' --}}
                                            <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank"
                                                class="text-gray-400 hover:text-indigo-600" title="Lihat Dokumen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.27 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('pegawai.dokumen.destroy', $dokumen->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600"
                                                    title="Hapus Dokumen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-12 px-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <p class="mt-4 text-sm font-medium text-gray-700">Belum Ada Dokumen</p>
                                <p class="mt-1 text-sm text-gray-500">Klik tombol '+' untuk menambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Tambah Dokumen --}}
    <div id="document-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden z-50 transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-8 m-4 transform" id="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Unggah Dokumen Baru</h3>
                <button id="close-modal-btn"
                    class="text-gray-400 hover:text-gray-800 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Pastikan route 'pegawai.dokumen.store' ada dan menerima parameter ID pegawai --}}
            <form action="{{ route('pegawai.dokumen.store', $pegawai->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
                        <input type="text" name="judul" id="judul" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="jenis_dokumen_input" class="block text-sm font-medium text-gray-700">Jenis
                            Dokumen</label>
                        {{-- Datalist adalah pilihan yang baik untuk memberikan saran tapi tetap mengizinkan input bebas --}}
                        <input list="jenis_dokumen_list" name="jenis_dokumen" id="jenis_dokumen_input" required
                            placeholder="Pilih atau ketik jenis dokumen"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <datalist id="jenis_dokumen_list">
                            <option value="SK CPNS"></option>
                            <option value="SK PNS"></option>
                            <option value="SK Kenaikan Pangkat"></option>
                            <option value="Ijazah"></option>
                            <option value="Transkrip Nilai"></option>
                            <option value="Sertifikat Pelatihan/Diklat"></option>
                            <option value="KTP (Kartu Tanda Penduduk)"></option>
                            <option value="KK (Kartu Keluarga)"></option>
                            <option value="NPWP"></option>
                            <option value="Buku Nikah"></option>
                        </datalist>
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700">Pilih File</label>
                        <input type="file" name="file" id="file" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" id="cancel-btn"
                        class="bg-white hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 border border-gray-300 rounded-lg shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm">
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
            const modal = document.getElementById('document-modal');
            const modalContent = document.getElementById('modal-content');
            const addBtn = document.getElementById('add-document-btn');
            const closeBtn = document.getElementById('close-modal-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const form = document.querySelector('#document-modal form');

            function showModal() {
                modal.classList.remove('hidden');
                setTimeout(() => { // Memberi sedikit waktu untuk transisi
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 10);
            }

            function hideModal() {
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => { // Tunggu animasi selesai sebelum menyembunyikan
                    modal.classList.add('hidden');
                    form.reset(); // Reset form setelah modal tertutup
                }, 300);
            }

            addBtn.addEventListener('click', showModal);
            closeBtn.addEventListener('click', hideModal);
            cancelBtn.addEventListener('click', hideModal);

            // Tutup modal jika klik di luar area konten modal
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    hideModal();
                }
            });

            // Tutup modal dengan tombol Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    hideModal();
                }
            });
        });
    </script>
@endpush

@push('styles')
    {{-- Style ini ditambahkan untuk mendukung animasi modal yang lebih halus --}}
    <style>
        #document-modal {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        #modal-content {
            transform: scale(0.95);
            transition: transform 0.3s ease-in-out;
        }
    </style>
@endpush
