@extends('layouts.app')

@section('title', 'Detail Data RTLH')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-house-user absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        Detail Data RTLH
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm">
                        Menampilkan rincian untuk: {{ $rumahTidakLayakHuni->nama_kepala_ruta }}
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('rtlh.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white/90 border border-transparent rounded-md font-semibold text-xs text-midnight_green-600 uppercase tracking-widest shadow-sm hover:bg-white transition">
                        Kembali
                    </a>
                    <a href="{{ route('rtlh.edit', $rumahTidakLayakHuni->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-ecru-300 border border-transparent rounded-md font-semibold text-xs text-ecru-900 uppercase tracking-widest shadow-sm hover:bg-ecru-400 transition">
                        Edit
                    </a>
                    <form action="{{ route('rtlh.destroy', $rumahTidakLayakHuni->id) }}" method="POST"
                        onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Konten Detail --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">

            {{-- SEKSI 1: INFORMASI PENGHUNI --}}
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                    Informasi Penghuni
                </h3>
                <div class="divide-y divide-slate-200">
                    @php
                        $penghuniDetails = [
                            'Nama Kepala Ruta' => $rumahTidakLayakHuni->nama_kepala_ruta,
                            'NIK' => $rumahTidakLayakHuni->nik,
                            'Umur' => $rumahTidakLayakHuni->umur . ' Tahun',
                            'Jenis Kelamin' => $rumahTidakLayakHuni->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                        ];
                    @endphp
                    @foreach ($penghuniDetails as $label => $value)
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
                            <span class="text-sm text-slate-900 font-semibold text-right">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SEKSI 2: DATA ALAMAT & PROPERTI --}}
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                    Data Alamat & Properti
                </h3>
                <div class="divide-y divide-slate-200">
                    @php
                        $propertiDetails = [
                            'Alamat Lengkap' => $rumahTidakLayakHuni->alamat,
                            'Desa/Kelurahan' => $rumahTidakLayakHuni->desa_kelurahan,
                            'Kecamatan' => $rumahTidakLayakHuni->kecamatan,
                            'Kode Wilayah' => $rumahTidakLayakHuni->kode_wilayah,
                            'Koordinat' => $rumahTidakLayakHuni->koordinat,
                            'Luas Rumah' => $rumahTidakLayakHuni->luas_rumah . ' M²',
                            'Kategori Rumah' => $rumahTidakLayakHuni->kategori_rumah,
                            'Kepemilikan Rumah' => $rumahTidakLayakHuni->kepemilikan_rumah,
                            'Kepemilikan Tanah' => $rumahTidakLayakHuni->kepemilikan_tanah,
                        ];
                    @endphp
                    @foreach ($propertiDetails as $label => $value)
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center py-3">
                            <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
                            <span
                                class="text-sm text-slate-900 font-semibold text-left sm:text-right">{{ $value ?? '—' }}</span>
                        </div>
                    @endforeach

                    {{-- Status Bantuan (Styling Khusus) --}}
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-slate-600">Status Bantuan</span>
                        @php
                            $statusClass = '';
                            if ($rumahTidakLayakHuni->status == 'sudah diperbaiki') {
                                $statusClass = 'bg-green-100 text-green-800';
                            } elseif ($rumahTidakLayakHuni->status == 'sedang diperbaiki') {
                                $statusClass = 'bg-yellow-100 text-yellow-800';
                            } else {
                                $statusClass = 'bg-red-100 text-red-800';
                            }
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize {{ $statusClass }}">
                            {{ $rumahTidakLayakHuni->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- SEKSI 3: DOKUMENTASI FOTO --}}
            <div>
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-6">
                    Dokumentasi Foto
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto Sebelum Perbaikan</label>
                        @if ($rumahTidakLayakHuni->foto_sebelum_perbaikan)
                            <a href="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sebelum_perbaikan) }}"
                                target="_blank">
                                <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sebelum_perbaikan) }}"
                                    alt="Foto Sebelum"
                                    class="w-full h-auto rounded-lg shadow-md border border-slate-200 object-cover">
                            </a>
                        @else
                            <div
                                class="flex items-center justify-center h-48 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300">
                                <p class="text-slate-500 italic text-sm">Tidak ada foto.</p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto Sesudah Perbaikan</label>
                        @if ($rumahTidakLayakHuni->foto_sesudah_perbaikan)
                            <a href="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sesudah_perbaikan) }}"
                                target="_blank">
                                <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_sesudah_perbaikan) }}"
                                    alt="Foto Sesudah"
                                    class="w-full h-auto rounded-lg shadow-md border border-slate-200 object-cover">
                            </a>
                        @else
                            <div
                                class="flex items-center justify-center h-48 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300">
                                <p class="text-slate-500 italic text-sm">Tidak ada foto.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
