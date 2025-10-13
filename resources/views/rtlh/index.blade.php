@extends('layouts.app')

@section('title', 'Daftar RTLH')
@section('header-title', 'Manajemen Data RTLH')

@section('content')
    <!-- Include file modal -->
    @include('rtlh._importModal')

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
            class="fas fa-house-damage absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10">
            <h3 class="text-2xl font-bold tracking-tight">
                Daftar Rumah Tidak Layak Huni (RTLH)
            </h3>
            <p class="mt-1 text-midnight_green-900/80 text-sm">Cari dan kelola data RTLH yang terdaftar di dalam sistem.</p>
        </div>
    </div>

    {{-- Panel Filter & Pencarian --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <i class="fas fa-filter text-midnight_green mr-3"></i>
            Filter & Pencarian
        </h3>
        <form action="{{ route('rtlh.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">

                {{-- 1. Search Input --}}
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / NIK</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search"
                            class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green"
                            placeholder="Masukkan Nama atau NIK..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- 2. Kecamatan Filter --}}
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

                {{-- 3. Desa/Kelurahan Filter --}}
                <div>
                    <label for="desa_kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Filter
                        Desa/Kelurahan</label>
                    <select name="desa_kelurahan" id="desa_kelurahan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">-- Semua Desa --</option>
                        @foreach ($desas as $item)
                            <option value="{{ $item->desa_kelurahan }}" @selected(request('desa_kelurahan') == $item->desa_kelurahan)>
                                {{ $item->desa_kelurahan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Kepemilikan Tanah Filter (BARU) --}}
                <div>
                    <label for="kepemilikan_tanah" class="block text-sm font-medium text-gray-700 mb-1">Filter
                        Kepemilikan</label>
                    <select name="kepemilikan_tanah" id="kepemilikan_tanah"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green">
                        <option value="">-- Semua Kepemilikan --</option>
                        {{-- Asumsi $kepemilikanTanahOptions dikirim dari Controller --}}
                        @foreach ($kepemilikanTanahOptions as $item)
                            <option value="{{ $item->kepemilikan_tanah }}" @selected(request('kepemilikan_tanah') == $item->kepemilikan_tanah)>
                                {{ $item->kepemilikan_tanah }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Baris Tombol Aksi Form --}}
            <div class="flex flex-wrap justify-between items-center mt-6 gap-4">
                {{-- Tombol Filter & Reset di Kiri --}}
                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="inline-flex items-center bg-midnight_green hover:bg-midnight_green-700 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                    <a href="{{ route('rtlh.index') }}"
                        class="inline-flex items-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 border border-gray-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        <i class="fas fa-sync-alt mr-2 text-gray-600"></i>
                        Reset
                    </a>
                    <a href="{{ route('map.index') }}"
                        class="inline-flex items-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 border border-emerald-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        <i class="fas fa-map-marked-alt mr-2 text-emerald-600"></i>
                        Peta Sebaran RTLH
                    </a>
                    <a href="{{ route('rtlh.export') }}"
                        class="inline-flex items-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 border border-emerald-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        <i class="fas fa-file-export mr-2 text-emerald-600"></i>
                        Export Data RTLH
                    </a>
                    <button data-modal-toggle="importModal" type="button"
                        class="inline-flex items-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 border border-emerald-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        Import Data
                    </button>

                </div>

                @if (Auth::check() &&
                        (Auth::user()->role == 'admin' || (Auth::user()->bidang && Auth::user()->bidang->nama_bidang == 'permukiman')))
                    {{-- Tombol Tambah di Kanan --}}
                    <a href="{{ route('rtlh.create') }}"
                        class="bg-midnight_green hover:bg-midnight_green-600 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-plus fa-fw"></i>
                        <span>Tambah Data</span>
                    </a>
                @endif
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
                            Nama Kepala Ruta</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Kecamatan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Kepemilikan Tanah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-midnight_green-400 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($data as $item)
                        <tr class="hover:bg-ecru-900/60 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration + $data->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-midnight_green-200 font-medium">{{ $item->nama_kepala_ruta }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->nik }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->kecamatan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $item->kepemilikan_tanah }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('rtlh.show', $item->id) }}" title="Lihat"
                                    class="text-gray-500 hover:text-midnight_green p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (Auth::check() &&
                                        (Auth::user()->role == 'admin' || (Auth::user()->bidang && Auth::user()->bidang->nama_bidang == 'permukiman')))
                                    <a href="{{ route('rtlh.edit', $item->id) }}" title="Edit"
                                        class="text-ecru-300 hover:text-ecru-400 p-2 w-9 h-9 flex items-center justify-center rounded-lg transition-all duration-200 transform hover:scale-110">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('rtlh.destroy', $item->id) }}" method="POST"
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
                                            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m-3-1l-3-1m-3 1l-3 1m12-4.272l-3-1m-3 1l-3-1" />
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
        @if ($data->hasPages())
            <div class="p-5 border-t border-gray-200 bg-ecru-900">
                {!! $data->appends(request()->query())->links() !!}
            </div>
        @endif
    </div>
@endsection
