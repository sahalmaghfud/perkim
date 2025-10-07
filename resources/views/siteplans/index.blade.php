@extends('layouts.app')

@push('styles')
    <style>
        .auto-dismiss-alert {
            transition: opacity 0.5s ease-out;
        }
    </style>
@endpush

@section('content')
    {{-- Latar belakang utama halaman --}}
    <div class="min-h-screen">
        <div class="container mx-auto py-8">
            <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">

                {{-- Ini adalah ikon dekoratif besar di latar belakang --}}
                <i
                    class="fas fa-file-alt absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>

                {{-- Ini adalah konten teks di bagian depan --}}
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold tracking-tight">
                        {{-- Judul akan berubah secara dinamis jika ada variabel $bidangTerpilih --}}

                        Data Siteplan
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm">
                </div>
            </div>

            {{-- ALERT NOTIFICATIONS --}}
            @if (session('success'))
                <div class="bg-midnight_green-900 border-l-4 border-midnight_green text-midnight_green-400 p-4 mb-4 rounded-md shadow-sm auto-dismiss-alert"
                    role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow-sm auto-dismiss-alert"
                    role="alert">
                    <p class="font-bold">Gagal</p>
                    <p>{!! session('error') !!}</p>
                </div>
            @endif

            {{-- FORM FILTER --}}
            <div class="bg-white p-4 rounded-lg shadow-md mb-6 border border-gray-200">
                <form action="{{ route('siteplans.index') }}" method="GET">
                    {{-- Mengubah grid menjadi 3 kolom di layar besar untuk mengakomodasi filter tambahan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- 1. Input Pencarian Umum --}}
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Nama Pemohon..."
                            class="w-full bg-white border-gray-300 text-gray-700 rounded-md shadow-sm focus:ring-midnight_green focus:border-midnight_green">

                        {{-- 2. Filter Berdasarkan Nama PT (Data dari Controller) --}}
                        <select name="nama_pt"
                            class="w-full bg-white border-gray-300 text-gray-700 rounded-md shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                            <option value="">Semua Perusahaan/PT</option>
                            @foreach ($namaPts as $item)
                                <option value="{{ $item->nama_pt }}" @selected(request('nama_pt') == $item->nama_pt)>
                                    {{ $item->nama_pt }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 3. Filter Berdasarkan Kecamatan (Data dari Controller) --}}
                        <select name="kecamatan"
                            class="w-full bg-white border-gray-300 text-gray-700 rounded-md shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatans as $item)
                                <option value="{{ $item->kecamatan }}" @selected(request('kecamatan') == $item->kecamatan)>
                                    {{ $item->kecamatan }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 4. Filter Berdasarkan Desa (Data dari Controller) --}}
                        <select name="desa"
                            class="w-full bg-white border-gray-300 text-gray-700 rounded-md shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                            <option value="">Semua Desa/Kelurahan</option>
                            @foreach ($desas as $item)
                                <option value="{{ $item->desa }}" @selected(request('desa') == $item->desa)>
                                    {{ $item->desa }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 5. Filter Berdasarkan Keterangan (Hardcoded) --}}
                        <select name="keterangan"
                            class="w-full bg-white border-gray-300 text-gray-700 rounded-md shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                            <option value="">Semua Keterangan</option>
                            <option value="Jatuh Tempo" @selected(request('keterangan') == 'Jatuh Tempo')>Jatuh Tempo</option>
                            <option value="Proses" @selected(request('keterangan') == 'Proses')>Proses</option>
                            <option value="Selesai" @selected(request('keterangan') == 'Selesai')>Selesai</option>
                        </select>

                        {{-- 6. Tombol Aksi --}}
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-full bg-midnight_green text-white font-semibold py-2 px-4 rounded-lg hover:bg-midnight_green-600">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <a href="{{ route('siteplans.index') }}"
                                class="w-full text-center bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300">
                                <i class="fas fa-sync-alt mr-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TOMBOL AKSI UTAMA --}}
            <div class="mb-4 flex items-center space-x-2">
                {{-- Tampilkan tombol Tambah & Import hanya untuk Admin atau Bidang Perumahan --}}
                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'perumahan'))
                    <a href="{{ route('siteplans.create') }}"
                        class="bg-midnight_green text-white font-semibold py-2 px-4 rounded-lg hover:bg-midnight_green-600 flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Data
                    </a>
                    <button type="button" id="btn-open-import-modal"
                        class="bg-ecru-500 text-midnight_green-300 font-semibold py-2 px-4 rounded-lg hover:bg-ecru-600 flex items-center">
                        <i class="fas fa-upload mr-2"></i> Import Data
                    </button>
                @endif

                {{-- Tombol Export selalu tampil untuk semua user --}}
                <a href="{{ route('siteplans.export', request()->query()) }}"
                    class="bg-white border border-midnight_green text-midnight_green font-semibold py-2 px-4 rounded-lg hover:bg-ecru-900/60 flex items-center">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>
            </div>

            {{-- MODAL IMPORT --}}
            <div id="import-modal" class="fixed inset-0 z-50 hidden">
                <div id="import-modal-overlay" class="absolute inset-0 bg-black/70"></div>
                <div
                    class="relative bg-white w-full max-w-lg mx-auto mt-16 rounded-lg shadow-xl p-6 border border-gray-200">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
                        <h3 class="text-xl font-semibold text-midnight_green">Import Data Siteplan</h3>
                        <button id="btn-close-import-modal"
                            class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                    </div>
                    <form action="{{ route('siteplans.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <p class="text-sm text-gray-600">
                                Pilih file Excel (.xlsx, .xls) yang ingin Anda import. Pastikan format kolom sesuai.
                            </p>
                            <div>
                                <label for="import_file" class="block text-sm font-medium text-gray-700">Pilih File</label>
                                <input type="file" name="file" id="import_file" required
                                    class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                        file:text-sm file:font-semibold file:bg-midnight_green/20 file:text-midnight_green
                                        hover:file:bg-midnight_green/30" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-6 border-t border-gray-200 pt-4">
                            <button type="submit"
                                class="bg-midnight_green text-white font-semibold py-2 px-4 rounded-lg hover:bg-midnight_green-600 flex items-center">
                                <i class="fas fa-upload mr-2"></i>Mulai Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-ecru-900">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                                    Nama Perumahan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                                    Nama PT</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                                    Kecamatan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                                    Keterangan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($siteplans as $siteplan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $siteplan->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $siteplan->nama_pt }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $siteplan->kecamatan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $siteplan->keterangan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('siteplans.show', $siteplan->id) }}"
                                                class="text-midnight_green hover:text-midnight_green-600" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'perumahan'))
                                                <a href="{{ route('siteplans.edit', $siteplan->id) }}"
                                                    class="text-ecru-300 hover:text-ecru-400" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('siteplans.destroy', $siteplan->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-white border-t border-gray-200">
                    {{ $siteplans->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{-- Script tetap sama, tidak perlu diubah --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importModal = document.getElementById('import-modal');
            const openImportModalBtn = document.getElementById('btn-open-import-modal');
            const closeImportModalBtn = document.getElementById('btn-close-import-modal');
            const importModalOverlay = document.getElementById('import-modal-overlay');

            if (importModal && openImportModalBtn && closeImportModalBtn && importModalOverlay) {
                const openImportModal = () => importModal.classList.remove('hidden');
                const closeImportModal = () => importModal.classList.add('hidden');
                openImportModalBtn.addEventListener('click', openImportModal);
                closeImportModalBtn.addEventListener('click', closeImportModal);
                importModalOverlay.addEventListener('click', closeImportModal);
            }

            const alert = document.querySelector('.auto-dismiss-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000); // Durasi notifikasi sedikit diperpanjang
            }
        });
    </script>
@endpush
