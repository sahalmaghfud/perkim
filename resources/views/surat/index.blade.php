{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi @yield('title') di layout --}}
@section('title', 'Daftar Surat')

@section('header-title')
    {{-- Jika variabel $divisiTerpilih ada, tampilkan nama divisinya. Jika tidak, tampilkan judul default. --}}
    @if (isset($divisiTerpilih))
        Manajemen Surat - Divisi {{ $divisiTerpilih->nama_divisi }}
    @else
        Manajemen Semua Surat
    @endif
@endsection

{{-- Mengisi @yield('content') di layout --}}
@section('content')

    {{-- Notifikasi Sukses dengan style Tailwind --}}
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

    {{-- Kontainer utama untuk daftar surat --}}
    <div class="bg-white rounded-lg shadow-md">

        {{-- Header section dengan judul dan tombol tambah --}}
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Semua Surat</h3>
            @if (auth()->user()->divisi_id == $divisiTerpilih->id)
                <a href="{{ route('surat.create', ['divisi_id' => $divisiTerpilih->id ?? null]) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 flex items-center gap-2 text-sm shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Surat</span>
                </a>
            @endif
        </div>

        {{-- Kontainer tabel agar responsif --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor
                            Surat</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perihal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal
                            Surat</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Divisi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loop->iteration + $surats->firstItem() - 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $surat->nomor_surat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $surat->perihal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 inline-block text-xs font-semibold rounded-full
                                    {{ $surat->jenis_surat == 'Surat Masuk' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $surat->jenis_surat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $surat->divisi->nama_divisi ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                                {{-- Tombol Lihat --}}
                                <a href="{{ Storage::url($surat->file_path) }}" target="_blank" title="Lihat"
                                    class="bg-gray-500 hover:bg-gray-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Cek otorisasi untuk tombol Edit dan Hapus --}}
                                @if (auth()->user()->divisi_id == $surat->divisi_id)
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('surat.edit', $surat->id) }}" title="Edit"
                                        class="bg-amber-500 hover:bg-amber-600 text-white p-2 w-8 h-8 flex items-center justify-center rounded-md transition-colors shadow-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('surat.destroy', $surat->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
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
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data surat yang
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tampilkan link paginasi --}}
        <div class="p-5 border-t border-gray-200">
            {{ $surats->appends(request()->query())->links() }}
        </div>

    </div>
@endsection

@push('scripts')
    {{-- (Opsional) Jika Anda ingin alert hilang otomatis setelah beberapa detik --}}
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
