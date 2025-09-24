@extends('layouts.app')

@push('styles')
    <style>
        .auto-dismiss-alert {
            transition: opacity 0.5s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-100 mb-6">Data Siteplan</h1>

        {{-- ALERT NOTIFICATIONS --}}
        @if (session('success'))
            <div class="bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 mb-4 rounded-md shadow-sm auto-dismiss-alert"
                role="alert">
                <p class="font-bold">Sukses</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 mb-4 rounded-md shadow-sm auto-dismiss-alert"
                role="alert">
                <p class="font-bold">Gagal</p>
                <p>{!! session('error') !!}</p>
            </div>
        @endif

        {{-- FORM FILTER --}}
        <div class="bg-gray-800 p-4 rounded-lg shadow-md mb-6 border border-gray-700">
            <form action="{{ route('siteplans.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/PT..."
                        class="w-full bg-gray-700 border-gray-600 text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <select name="kecamatan"
                        class="w-full bg-gray-700 border-gray-600 text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $item)
                            <option value="{{ $item->kecamatan }}"
                                {{ request('kecamatan') == $item->kecamatan ? 'selected' : '' }}>
                                {{ $item->kecamatan }}
                            </option>
                        @endforeach
                    </select>

                    <select name="keterangan"
                        class="w-full bg-gray-700 border-gray-600 text-gray-200 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Keterangan</option>
                        <option value="Jatuh Tempo" {{ request('keterangan') == 'Jatuh Tempo' ? 'selected' : '' }}>Jatuh
                            Tempo</option>
                        <option value="Proses" {{ request('keterangan') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ request('keterangan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <div class="flex items-center space-x-2">
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('siteplans.index') }}"
                            class="w-full text-center bg-gray-600 text-gray-200 font-semibold py-2 px-4 rounded-lg hover:bg-gray-500">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- TOMBOL AKSI UTAMA --}}
        <div class="mb-4 flex items-center space-x-2">
            <a href="{{ route('siteplans.create') }}"
                class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </a>
            <button type="button" id="btn-open-import-modal"
                class="bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-600 flex items-center">
                <i class="fas fa-upload mr-2"></i> Import Data
            </button>
            <a href="{{ route('siteplans.export', request()->query()) }}"
                class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 flex items-center">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </a>
        </div>

        {{-- MODAL IMPORT --}}
        <div id="import-modal" class="fixed inset-0 z-50 hidden">
            <div id="import-modal-overlay" class="absolute inset-0 bg-black/70"></div>
            <div class="relative bg-gray-800 w-full max-w-lg mx-auto mt-16 rounded-lg shadow-xl p-6 border border-gray-700">
                <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
                    <h3 class="text-xl font-semibold text-gray-100">Import Data Siteplan</h3>
                    <button id="btn-close-import-modal" class="text-gray-400 hover:text-gray-100 text-2xl">&times;</button>
                </div>
                <form action="{{ route('siteplans.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <p class="text-sm text-gray-400">
                            Pilih file Excel (.xlsx, .xls) yang ingin Anda import. Pastikan format kolom sesuai.
                        </p>
                        <div>
                            <label for="import_file" class="block text-sm font-medium text-gray-300">Pilih File</label>
                            <input type="file" name="file" id="import_file" required
                                class="mt-1 block w-full text-sm text-gray-400
                                   file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                   file:text-sm file:font-semibold file:bg-indigo-600/20 file:text-indigo-300
                                   hover:file:bg-indigo-600/30" />
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 border-t border-gray-700 pt-4">
                        <button type="submit"
                            class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 flex items-center">
                            <i class="fas fa-upload mr-2"></i>Mulai Import
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL DATA --}}
        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nama Perumahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Nama PT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kecamatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse ($siteplans as $siteplan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">
                                    {{ $siteplan->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $siteplan->nama_pt }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $siteplan->kecamatan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $siteplan->keterangan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('siteplans.show', $siteplan->id) }}"
                                            class="text-blue-400 hover:text-blue-300" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('siteplans.edit', $siteplan->id) }}"
                                            class="text-yellow-400 hover:text-yellow-300" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('siteplans.destroy', $siteplan->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-800 border-t border-gray-700">
                {{ $siteplans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection


@push('scripts')
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
                }, 1500);
            }
        });
    </script>
@endpush
