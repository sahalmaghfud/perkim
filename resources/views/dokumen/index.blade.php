@extends('layouts.app')

@section('title', 'Daftar Dokumen')

@section('header-title', 'Manajemen Dokumen')

@section('content')
    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div id="success-alert"
            class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex justify-between items-center shadow-sm"
            role="alert">
            <p class="font-medium">{{ session('success') }}</p>
            <button type="button" onclick="document.getElementById('success-alert').style.display='none'" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">
                {{-- [PENYESUAIAN] Judul dinamis berdasarkan konteks --}}
                @isset($bidangTerpilih)
                    Dokumen Bidang: {{ $bidangTerpilih->nama_bidang }}
                @else
                    Semua Dokumen
                @endisset
            </h3>
            {{-- [PENYESUAIAN] Tombol Tambah mengarah ke route standar --}}
            <a href="{{ route('dokumen.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                <i class="fas fa-plus"></i>
                <span>Tambah Dokumen</span>
            </a>
        </div>

        {{-- FORM PENCARIAN DAN FILTER --}}
        <div class="p-5 bg-gray-50">
            {{-- [PENYESUAIAN] Action form mengarah ke route index atau bidang --}}
            <form
                action="{{ isset($bidangTerpilih) ? route('dokumen.bidang', $bidangTerpilih->nama_bidang) : route('dokumen.index') }}"
                method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokumen</label>
                        {{-- [PENYESUAIAN] Placeholder diubah --}}
                        <input type="text" name="search" id="search"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari berdasarkan judul..." value="{{ request('search') }}">
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                    {{ $k }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- [PENYESUAIAN] Filter diubah dari divisi ke bidang --}}
                    <div>
                        <label for="bidang_id" class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                        <select name="bidang_id" id="bidang_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Bidang</option>
                            @foreach ($bidangList as $bidang)
                                <option value="{{ $bidang->id }}"
                                    {{ request('bidang_id', $bidangTerpilih->id ?? '') == $bidang->id ? 'selected' : '' }}>
                                    {{ $bidang->nama_bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                        Filter
                    </button>
                    <a href="{{ isset($bidangTerpilih) ? route('dokumen.bidang', $bidangTerpilih->nama_bidang) : route('dokumen.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        {{-- Kolom 'Kode Dokumen' dihapus --}}
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        {{-- [PENYESUAIAN] Kolom diubah --}}
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bidang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dokumens as $dokumen)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + $dokumens->firstItem() - 1 }}
                            </td>
                            {{-- Kolom data 'kode_dokumen' dihapus --}}
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $dokumen->judul }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $dokumen->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $dokumen->tipe_dokumen == 'surat' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ Str::title($dokumen->tipe_dokumen) }}
                                </span>
                            </td>
                            {{-- [PENYESUAIAN] Menampilkan 'tanggal' --}}
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($dokumen->tanggal)->format('d M Y') }}</td>
                            {{-- [PENYESUAIAN] Menampilkan 'bidang' --}}
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $dokumen->bidang->nama_bidang ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" title="Lihat"
                                    class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dokumen.edit', $dokumen->id) }}" title="Edit"
                                    class="bg-amber-500 hover:bg-amber-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- [PENYESUAIAN] Colspan disesuaikan --}}
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-5 border-t border-gray-200">
            {{ $dokumens->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
