{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') di layout --}}
@section('title', 'Daftar Dokumen')

@section('header-title', 'Manajemen Dokumen')

{{-- Mengisi @yield('content') di layout --}}
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

    {{-- Kontainer utama untuk daftar dokumen --}}
    <div class="bg-white rounded-lg shadow-md">

        {{-- Header section dengan judul dan tombol tambah --}}
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Dokumen</h3>
            @if (auth()->user()->divisi_id == $divisiTerpilih->id)
                <a href="{{ route('dokumen.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Dokumen</span>
                </a>
            @endif
        </div>

        {{-- FORM PENCARIAN DAN FILTER --}}
        <div class="p-5 bg-gray-50">
            {{-- [PENYESUAIAN] Action form mengarah ke route showByDivisi --}}
            <form action="{{ route('dokumen.divisi', $divisiTerpilih->nama_divisi) }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Input Pencarian --}}
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokumen</label>
                        <input type="text" name="search" id="search"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Judul atau Kode Dokumen..." value="{{ request('search') }}">
                    </div>

                    {{-- Filter Kategori --}}
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

                    {{-- Filter Divisi --}}
                    {{-- <div>
                        <label for="divisi_id" class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                        <select name="divisi_id" id="divisi_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Divisi</option>
                            @foreach ($divisiList as $divisi)
                                {{-- [PENYESUAIAN] Logika 'selected' yang lebih baik --}}
                    {{--     <option value="{{ $divisi->id }}"
                                    {{ request('divisi_id', $divisiTerpilih->id) == $divisi->id ? 'selected' : '' }}>
                                    {{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                        <i class="fas fa-filter"></i>
                        <span>Filter</span>
                    </button>
                    {{-- [PENYESUAIAN] Link Reset mengarah kembali ke halaman divisi saat ini tanpa filter --}}
                    <a href="{{ route('dokumen.divisi', $divisiTerpilih->nama_divisi) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                        <i class="fas fa-sync-alt"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>

        {{-- Kontainer tabel agar responsif --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode
                            Dokumen</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Kategori</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal
                            Terbit</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Divisi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dokumens as $dokumen)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loop->iteration + $dokumens->firstItem() - 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $dokumen->kode_dokumen }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dokumen->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 inline-block text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $dokumen->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($dokumen->tanggal_terbit)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dokumen->divisi->nama_divisi ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                                {{-- Tombol Lihat --}}
                                <a href="{{ Storage::url($dokumen->file_path) }}" target="_blank" title="Lihat"
                                    class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (auth()->user()->divisi_id == $dokumen->divisi_id)
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" title="Edit"
                                        class="bg-amber-500 hover:bg-amber-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data dokumen yang
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tampilkan link paginasi --}}
        <div class="p-5 border-t border-gray-200">
            {{ $dokumens->appends(request()->query())->links() }}
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Skrip untuk menghilangkan notifikasi sukses secara otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }, 5000); // Hilang setelah 5 detik
            }
        });
    </script>
@endpush
