@extends('layouts.app')

@section('title', 'Daftar Jalan Lingkungan')
@section('header-title', 'Manajemen Jalan Lingkungan')

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

    {{-- Panel Judul --}}
    <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
        <i
            class="fas fa-road absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold tracking-tight">
                Data Pekerjaan Jalan Lingkungan
            </h3>
            <p class="mt-1 text-midnight_green-900/80 text-sm">Cari dan kelola semua data pekerjaan jalan lingkungan di
                dalam sistem.</p>
        </div>
    </div>

    {{-- Panel Filter & Pencarian --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <i class="fas fa-filter text-midnight_green mr-3"></i>
            Filter Data
        </h3>
        <form action="{{ route('jalan_lingkungan.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                {{-- Kecamatan Filter --}}
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Filter Kecamatan</label>
                    <select name="kecamatan" id="kecamatan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">-- Semua Kecamatan --</option>
                        @foreach ($kecamatans as $item)
                            <option value="{{ $item->kecamatan }}" @selected(request('kecamatan') == $item->kecamatan)>
                                {{ $item->kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Desa Filter --}}
                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-1">Filter Desa</label>
                    <select name="desa" id="desa"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">-- Semua Desa --</option>
                        @foreach ($desas as $item)
                            <option value="{{ $item->desa }}" @selected(request('desa') == $item->desa)>
                                {{ $item->desa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Filter --}}
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Filter Tahun</label>
                    <select name="tahun" id="tahun"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">-- Semua Tahun --</option>
                        @foreach ($tahuns as $item)
                            <option value="{{ $item->tahun }}" @selected(request('tahun') == $item->tahun)>
                                {{ $item->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Baris Tombol Aksi Form --}}
            <div class="flex justify-between items-center mt-6">
                {{-- Tombol Filter & Reset di Kiri --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                        Filter
                    </button>
                    <a href="{{ route('jalan_lingkungan.index') }}"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-2 px-5 rounded-lg transition-all duration-300 border border-gray-300 shadow-sm transform hover:scale-105">
                        Reset
                    </a>
                    <a href="{{ route('jalanlingkungan.export', request()->query()) }}"
                        class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-file-alt fa-fw"></i>
                        <span>Export Data</span>
                    </a>
                </div>
                <div class="flex gap-3">
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'psu'))
                        <a href="/cv"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-file-alt fa-fw"></i>
                            <span>Edit Data CV</span>
                        </a>

                        <a href="{{ route('jalan_lingkungan.create') }}"
                            class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-plus fa-fw"></i>
                            <span>Tambah Data</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Panel Tabel Data --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead class="bg-ecru-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Uraian Pekerjaan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            CV Pelaksana</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Nilai Kontrak</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jalanLingkungans as $item)
                        <tr class="hover:bg-ecru-900/60 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $loop->iteration + $jalanLingkungans->firstItem() - 1 }}</td>
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">{{ $item->uraian }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->cv->nama_cv ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="font-semibold">{{ $item->kecamatan }}</div>
                                <div class="text-xs text-gray-500">{{ $item->desa }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">
                                {{ $item->nilai_kontrak ? 'Rp ' . number_format($item->nilai_kontrak, 0, ',', '.') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('jalan_lingkungan.show', $item->id) }}" title="Lihat"
                                    class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'psu'))
                                    <a href="{{ route('jalan_lingkungan.edit', $item->id) }}" title="Edit"
                                        class="text-ecru-300 hover:text-ecru-400 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('jalan_lingkungan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
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
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Data Ditemukan</h3>
                                    <p class="text-sm mt-1">Belum ada data yang ditambahkan atau sesuai dengan filter Anda.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if ($jalanLingkungans->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {!! $jalanLingkungans->links() !!}
            </div>
        @endif
    </div>
@endsection
