@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('header-title', 'Manajemen Data Pegawai')

@section('content')
    {{-- Notifikasi Sukses (jika ada) --}}
    @if (session('success'))
        <div id="success-alert"
            class="flex items-start gap-4 p-4 mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-lg shadow-sm"
            role="alert">
            <div class="text-green-600">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-green-800">Sukses</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="document.getElementById('success-alert').remove()" aria-label="Close"
                class="text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- Kontainer utama untuk daftar pegawai --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">

        {{-- Header Card --}}
        <div class="p-6 border-b border-gray-200 sm:flex sm:justify-between sm:items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Data Pegawai</h3>
                <p class="mt-1 text-sm text-gray-500">Daftar semua pegawai yang tercatat di dalam sistem.</p>
            </div>

            <div class="mt-4 sm:mt-0 flex gap-2">
                {{-- Tombol Export Excel --}}
                <a href="{{ route('pegawai.export') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-lg shadow-sm hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                    <i class="fas fa-file-excel"></i>
                    <span>Export Excel</span>
                </a>

                {{-- Tombol Tambah Pegawai --}}

            </div>
        </div>

        {{-- Kontainer Tabel Responsif --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pegawai
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">NIP</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Divisi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jabatan
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tgl. Masuk
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pegawai as $p)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pegawai->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        {{-- Placeholder untuk foto profil, bisa diganti dengan foto asli --}}
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span
                                                class="font-bold text-blue-600">{{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $p->nama_lengkap }}</div>
                                        <div class="text-sm text-gray-500">{{ $p->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->nip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="px-3 py-1 inline-flex text-xs font-semibold rounded-full leading-5 bg-indigo-100 text-indigo-800">
                                    {{ $p->divisi->nama_divisi ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $p->jabatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($p->tanggal_masuk)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex items-center justify-center gap-3">
                                    {{-- <a href="#" title="Detail Pegawai"
                                        class="text-gray-500 hover:text-blue-600 transition">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                    <a href="#" title="Edit Pegawai"
                                        class="text-gray-500 hover:text-amber-600 transition">
                                        <i class="fas fa-pencil-alt fa-fw"></i>
                                    </a>
                                    <form action="#" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Pegawai"
                                            class="text-gray-500 hover:text-red-600 transition">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada data pegawai --}}
                        <tr>
                            <td colspan="7">
                                <div class="text-center py-16 px-6">
                                    <i class="fas fa-users-slash fa-4x text-gray-300 mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-700">Belum Ada Pegawai</h3>
                                    <p class="text-gray-500 mt-1">Data pegawai belum tersedia di dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Card - Paginasi --}}
        @if ($pegawai->hasPages())
            <div class="p-6 border-t border-gray-200 sm:flex sm:justify-between sm:items-center">
                <p class="text-sm text-gray-600 mb-4 sm:mb-0">
                    Menampilkan <span class="font-semibold">{{ $pegawai->firstItem() }}</span>
                    sampai <span class="font-semibold">{{ $pegawai->lastItem() }}</span>
                    dari <span class="font-semibold">{{ $pegawai->total() }}</span> data
                </p>
                <div>
                    {{ $pegawai->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
