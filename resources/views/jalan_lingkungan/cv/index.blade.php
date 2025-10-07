@extends('layouts.app')

@section('title', 'Daftar CV')
@section('header-title', 'Manajemen CV')

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
            class="fas fa-building absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold tracking-tight">
                Data CV Perusahaan
            </h3>
            <p class="mt-1 text-midnight_green-900/80 text-sm">Cari dan kelola semua data CV yang terdaftar di sistem.</p>
        </div>
    </div>

    {{-- Panel Filter & Aksi --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex justify-between items-center">
            {{-- Form Pencarian --}}
            <form action="{{ route('cv.index') }}" method="GET" class="w-full max-w-sm">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search"
                        class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green"
                        placeholder="Cari Nama CV, NPWP, Direktur..." value="{{ request('search') }}">
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('cv.create') }}"
                class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                <i class="fas fa-plus fa-fw"></i>
                <span>Tambah CV</span>
            </a>
        </div>
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
                            Nama CV</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            NPWP</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Nomor Rekening</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Nama Direktur</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($cvs as $cv)
                        <tr class="hover:bg-ecru-900/60 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + $cvs->firstItem() - 1 }}</td>
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">{{ $cv->nama_cv }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $cv->npwp ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $cv->nomor_rekening ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $cv->nama_direktur ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('cv.show', $cv->id) }}" title="Lihat"
                                    class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cv.edit', $cv->id) }}" title="Edit"
                                    class="text-ecru-300 hover:text-ecru-400 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('cv.destroy', $cv->id) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus data CV ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="text-red-500 hover:text-red-600 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
                                    <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Data CV Ditemukan</h3>
                                    <p class="text-sm mt-1">Belum ada data CV yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if ($cvs->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {!! $cvs->links() !!}
            </div>
        @endif
    </div>
@endsection
