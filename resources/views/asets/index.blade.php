@extends('layouts.app')

@section('title', 'Daftar Aset')

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

    {{-- Header Halaman --}}
    <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
        <i
            class="fas fa-archive absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold tracking-tight">Manajemen Aset</h3>
                <p class="mt-1 text-midnight_green-100/80 text-sm">Kelola semua aset inventaris Dinas Perkim.</p>
            </div>
            <a href="{{ route('asets.create') }}"
                class="inline-flex items-center gap-2 bg-white text-green-900 font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105">
                <i class="fas fa-plus fa-fw"></i>
                <span>Tambah Aset</span>
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
                            Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            KIB</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Nilai Buku (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($asets as $index => $aset)
                        <tr class="hover:bg-ecru-900/60 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $asets->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                @if ($aset->foto_barang)
                                    <img src="{{ asset('storage/' . $aset->foto_barang) }}" alt="{{ $aset->nama_barang }}"
                                        class="h-12 w-16 object-cover rounded-md shadow-sm">
                                @else
                                    <div
                                        class="h-12 w-16 bg-gray-200 rounded-md flex items-center justify-center text-xs text-gray-400">
                                        N/A</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">{{ $aset->nama_barang }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $aset->jenis_kib }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $aset->tahun_perolehan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 text-right">
                                {{ number_format($aset->nilai_buku, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('asets.show', $aset->id) }}" title="Lihat"
                                    class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('asets.edit', $aset->id) }}" title="Edit"
                                    class="text-ecru-300 hover:text-ecru-400 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('asets.destroy', $aset->id) }}" method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus aset ini?');">
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
                            <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Data Aset</h3>
                                    <p class="text-sm mt-1">Belum ada data yang ditambahkan. Silakan klik tombol "Tambah
                                        Aset".</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($asets->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {{ $asets->links() }}
            </div>
        @endif
    </div>
@endsection
