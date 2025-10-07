@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman yang Diperbarui --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-users absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
                {{-- Judul --}}
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        Manajemen Pegawai
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm">Cari, lihat, dan kelola data pegawai.</p>
                </div>

                {{-- Aksi: Pencarian & Tombol Tambah --}}
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <form action="{{ route('pegawai.index') }}" method="GET" class="w-full md:w-64">
                        {{-- Form pencarian bisa ditambahkan di sini jika perlu --}}
                    </form>
                    <a href="{{ route('pegawai.export') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition-all whitespace-nowrap shadow-md">
                        <i class="fas fa-file-export mr-2"></i>
                        Export
                    </a>
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'sekertariat'))
                        <a href="{{ route('pegawai.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-ecru-500 border border-transparent rounded-lg font-semibold text-xs text-midnight_green uppercase tracking-widest hover:bg-ecru-600 transition-all whitespace-nowrap shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah
                        </a>
                    @endif


                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-r-lg shadow-sm"
                role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <div>
                        <p class="font-bold">Sukses</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                    <div>
                        <p class="font-bold">Gagal</p>
                        <p>{!! session('error') !!}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Kontainer Tabel yang Diperbarui --}}
        <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    {{-- Header Tabel yang Diperbarui --}}
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Nama / NIP</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Pangkat / Gol.</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Jabatan</th>
                            {{-- KOLOM BARU UNTUK STATUS --}}
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Status KP</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse ($pegawais as $pegawai)
                            {{-- Baris dengan Efek Hover --}}
                            <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ ($pegawais->currentPage() - 1) * $pegawais->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $pegawai->foto ? Storage::url($pegawai->foto) : 'https://placehold.co/40x40/e2e8f0/e2e8f0?text=.' }}"
                                                alt="Foto {{ $pegawai->nama }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $pegawai->nama }}</div>
                                            <div class="text-sm text-slate-500">{{ $pegawai->nip }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($pegawai->pangkat)
                                        <div class="text-sm text-slate-900">{{ $pegawai->pangkat->pangkat }}</div>
                                        <div class="text-sm text-slate-500">
                                            {{ $pegawai->pangkat->golongan }}/{{ $pegawai->pangkat->ruang }}</div>
                                    @else
                                        <span class="text-sm text-slate-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    {{ $pegawai->nama_jabatan ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        // Ambil data status pangkat dari objek pegawai
                                        $status = $pegawai->status_pangkat;

                                        // Tentukan kelas warna Tailwind berdasarkan nilai 'color'
                                        $colorClass =
                                            [
                                                'green' => 'bg-green-500',
                                                'yellow' => 'bg-yellow-500',
                                                'red' => 'bg-red-500',
                                                'gray' => 'bg-gray-400',
                                            ][$status['color']] ?? 'bg-gray-400'; // Default ke abu-abu jika warna tidak ditemukan
                                    @endphp
                                    {{-- Tampilkan titik dengan warna dan tooltip yang sesuai --}}
                                    <span class="inline-block h-3 w-3 rounded-full {{ $colorClass }}"
                                        title="{{ $status['tooltip'] }}"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- Tombol Aksi yang Diperbarui --}}
                                    <div class="flex items-center justify-center space-x-4">
                                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->bidang->nama_bidang == 'sekertariat'))
                                            <a href="{{ route('pegawai.show', $pegawai->id) }}"
                                                class="text-slate-500 hover:text-midnight_green-500" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                                class="text-slate-500 hover:text-blue-600" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 hover:text-red-600"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Pastikan colspan disesuaikan menjadi 6 karena ada penambahan 1 kolom --}}
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <i class="fas fa-folder-open text-4xl text-slate-300 mb-2"></i>
                                    <p class="font-semibold">Tidak ada data pegawai yang ditemukan.</p>
                                    @if (request('search'))
                                        <p class="mt-1">Coba kata kunci lain atau <a href="{{ route('pegawai.index') }}"
                                                class="text-midnight_green hover:underline">hapus filter
                                                pencarian</a>.</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginasi (Styling Tailwind default biasanya sudah baik) --}}
        @if ($pegawais->hasPages())
            <div class="mt-6">
                {{ $pegawais->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
