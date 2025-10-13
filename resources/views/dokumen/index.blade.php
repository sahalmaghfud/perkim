@extends('layouts.app')

@section('title', 'Daftar Dokumen')
@section('header-title', 'Manajemen Dokumen')

@section('content')
    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div id="success-alert"
            class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg flex justify-between items-center shadow-md"
            role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.style.display='none'" aria-label="Close"
                class="text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- UPDATED: Panel Judul Disederhanakan --}}
    <div class="relative  bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
        <i
            class="fas fa-file-alt absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold tracking-tight">
                @isset($bidangTerpilih)
                    Dokumen Bidang: {{ $bidangTerpilih->nama_bidang }}
                @else
                    Semua Dokumen
                @endisset
            </h3>
            <p class="mt-1 text-midnight_green-900/80 text-sm">Cari dan kelola dokumen yang tersedia di dalam sistem.</p>
        </div>
    </div>

    {{-- UPDATED: Panel Filter dengan Tombol Tambah di Kanan --}}
    <div class="bg-white rounded-2xl shadow-xl p-5 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <i class="fas fa-filter text-midnight_green mr-3"></i>
            Filter & Pencarian
        </h3>
        <form
            action="{{ isset($bidangTerpilih) ? route('dokumen.bidang', $bidangTerpilih->nama_bidang) : route('dokumen.index') }}"
            method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokumen</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search"
                            class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green"
                            placeholder="Cari berdasarkan judul..." value="{{ request('search') }}">
                    </div>
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $k)
                            <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                {{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bidang_id" class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                    <select name="bidang_id" id="bidang_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">Semua Bidang</option>
                        @foreach ($bidangList as $bidang)
                            <option value="{{ $bidang->id }}"
                                {{ request('bidang_id', $bidangTerpilih->id ?? '') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- UPDATED: Layout baris tombol diubah --}}
            <div class="flex justify-between items-center mt-5">
                {{-- Tombol Filter & Reset di Kiri --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                        Filter
                    </button>
                    <a href="{{ isset($bidangTerpilih) ? route('dokumen.bidang', $bidangTerpilih->nama_bidang) : route('dokumen.index') }}"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-2 px-5 rounded-lg transition-all duration-300 border border-gray-300 shadow-sm transform hover:scale-105">
                        Reset
                    </a>
                </div>

                {{-- Tombol Tambah di Kanan --}}
                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang_id == $bidangTerpilih->bidang_id))
                    <a href="{{ route('dokumen.create') }}"
                        class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-plus fa-fw"></i>
                        <span>Tambah Dokumen</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Panel Tabel Data --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        {{-- ... Sisa kode untuk tabel tidak ada perubahan ... --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead class="bg-ecru-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Bidang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dokumens as $dokumen)
                        <tr class="hover:bg-ecru-900/60 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + $dokumens->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">{{ $dokumen->judul }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $dokumen->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-midnight_green-900 text-midnight_green-300">
                                    {{ Str::title($dokumen->tipe_dokumen) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $dokumen->bidang->nama_bidang ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                {{-- Tombol "Lihat" akan selalu tampil untuk semua user --}}
                                <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" title="Lihat"
                                    class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- LOGIKA BARU: Tampilkan jika user adalah 'admin' ATAU jika bidangnya sama --}}
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang_id == $dokumen->bidang_id))
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" title="Edit"
                                        class="text-ecru-300 hover:text-ecru-400 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus dokumen ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="text-red-500 hover:text-red-600 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Dokumen</h3>
                                    <p class="text-sm mt-1">Belum ada data yang ditambahkan atau sesuai dengan filter Anda.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dokumens->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {{ $dokumens->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
