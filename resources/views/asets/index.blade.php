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

    {{-- Panel Filter dan Pencarian --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <form action="{{ route('asets.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                {{-- Kolom Pencarian --}}
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Barang</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-midnight_green-500 focus:border-midnight_green-500 sm:text-sm"
                            placeholder="Contoh: Laptop, Meja..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Filter KIB --}}
                <div>
                    <label for="jenis_kib" class="block text-sm font-medium text-gray-700 mb-1">Filter KIB</label>
                    <select id="jenis_kib" name="jenis_kib"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-midnight_green-500 focus:border-midnight_green-500 sm:text-sm rounded-lg shadow-sm">
                        <option value="">Semua KIB</option>
                        <option value="KIB A" @if (request('jenis_kib') == 'KIB A') selected @endif>A - Tanah</option>
                        <option value="KIB B" @if (request('jenis_kib') == 'KIB B') selected @endif>B - Peralatan dan Mesin
                        </option>
                        <option value="KIB C" @if (request('jenis_kib') == 'KIB C') selected @endif>C - Gedung dan Bangunan
                        </option>
                        <option value="KIB D" @if (request('jenis_kib') == 'KIB D') selected @endif>D - Jalan, Irigasi, dan
                            Jaringan</option>
                        <option value="KIB E" @if (request('jenis_kib') == 'KIB E') selected @endif>E - Aset Tetap Lainnya
                        </option>
                        <option value="KIB F" @if (request('jenis_kib') == 'KIB F') selected @endif>F - Konstruksi Dalam
                            Pengerjaan</option>
                        {{-- Saya tambahkan opsi G dan H sesuai permintaan Anda --}}
                        <option value="KIB G" @if (request('jenis_kib') == 'KIB G') selected @endif>G - Aset Tak Berwujud
                        </option>
                        <option value="KIB H" @if (request('jenis_kib') == 'KIB H') selected @endif>H - Aset Lain-Lain</option>
                    </select>
                </div>

                {{-- Filter Tahun --}}
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Filter Tahun</label>
                    <select id="tahun" name="tahun"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-midnight_green-500 focus:border-midnight_green-500 sm:text-sm rounded-lg shadow-sm">
                        <option value="">Semua Tahun</option>
                        {{-- Anda perlu mengirim variabel $tahunOptions dari controller --}}
                        @foreach ($tahunOptions as $tahun)
                            <option value="{{ $tahun }}" @if (request('tahun') == $tahun) selected @endif>
                                {{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-end gap-3">
                <a href="{{ route('asets.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Reset
                    Filter</a>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-midnight_green-500 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:bg-midnight_green-600">
                    <i class="fas fa-filter fa-fw"></i>
                    <span>Terapkan</span>
                </button>
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
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">
                                {{ $aset->nama_barang }}</td>
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
                                    <i class="fas fa-search-minus text-gray-300 text-5xl mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-700">Aset Tidak Ditemukan</h3>
                                    <p class="text-sm mt-1">Tidak ada data yang cocok dengan kriteria filter Anda. Coba
                                        reset filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($asets->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {{-- PENTING: Tambahkan appends() agar parameter filter tetap ada saat pindah halaman --}}
                {{ $asets->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
