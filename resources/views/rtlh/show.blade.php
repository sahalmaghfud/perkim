@extends('layouts.app')

@section('title', 'Detail Data RTLH')
@section('header-title', 'Detail Data RTLH')

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
                        class="inline-flex items-center px-4 py-2 bg-white/90 border border-transparent rounded-md font-semibold text-xs text-green-900 uppercase tracking-widest shadow-sm hover:bg-white transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    @if (Auth::check() &&
                            (Auth::user()->role == 'admin' || (Auth::user()->bidang && Auth::user()->bidang->nama_bidang == 'permukiman')))
                        <a href="{{ route('rtlh.edit', $rumahTidakLayakHuni->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-green-900 uppercase tracking-widest shadow-sm hover:bg-white transition">
                            <i class="fas fa-pencil-alt mr-2"></i> Edit
                        </a>
                        <form action="{{ route('rtlh.destroy', $rumahTidakLayakHuni->id) }}" method="POST"
                            onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 transition">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Konten Detail --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">

            {{-- Grid utama untuk layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Kolom Kiri: Informasi Detail --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- SEKSI 1: INFORMASI PENGHUNI --}}
                    <div>
                        <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                            Informasi Penghuni
                        </h3>
                        <div class="divide-y divide-slate-200">
                            @php
                                $penghuniDetails = [
                                    'Nama Kepala Ruta' => $rumahTidakLayakHuni->nama_kepala_ruta,
                                    'NIK' => $rumahTidakLayakHuni->nik,
                                    'Umur' => $rumahTidakLayakHuni->umur ? $rumahTidakLayakHuni->umur . ' Tahun' : null,
                                    'Jenis Kelamin' =>
                                        $rumahTidakLayakHuni->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                                ];
                            @endphp
                            @foreach ($penghuniDetails as $label => $value)
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
                                    <span class="text-sm text-slate-900 font-semibold text-right">{{ $value ?? '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SEKSI 2: DATA ALAMAT & PROPERTI --}}
                    <div>
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
                                    'Luas Rumah' => $rumahTidakLayakHuni->luas_rumah
                                        ? $rumahTidakLayakHuni->luas_rumah . ' M²'
                                        : null,
                                    'Kepemilikan Tanah' => $rumahTidakLayakHuni->kepemilikan_tanah,
                                    'No. Dokumen Kepemilikan' => $rumahTidakLayakHuni->no_sertifikat,
                                ];
                            @endphp
                            @foreach ($propertiDetails as $label => $value)
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center py-3">
                                    <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
                                    <span
                                        class="text-sm text-slate-900 font-semibold text-left sm:text-right mt-1 sm:mt-0">{{ $value ?? '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SEKSI 3: KONDISI RUMAH --}}
                    <div>
                        <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                            Kondisi Fisik Rumah
                        </h3>
                        <div class="divide-y divide-slate-200">
                            @php
                                $kondisiDetails = [
                                    'Kondisi Atap' => $rumahTidakLayakHuni->kondisi_atap,
                                    'Kondisi Dinding' => $rumahTidakLayakHuni->kondisi_dinding,
                                    'Kondisi Lantai' => $rumahTidakLayakHuni->kondisi_lantai,
                                    'Sumber Air Bersih' => $rumahTidakLayakHuni->sumber_air,
                                    'Sanitasi / WC' => $rumahTidakLayakHuni->sanitasi_wc,
                                    'Kondisi Dapur' => $rumahTidakLayakHuni->dapur,
                                ];
                            @endphp
                            @foreach ($kondisiDetails as $label => $value)
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-sm font-medium text-slate-600">{{ $label }}</span>
                                    <span class="text-sm text-slate-900 font-semibold text-right">{{ $value ?? '—' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan: Foto Utama --}}
                <div class="lg:col-span-1">
                    <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                        Foto Rumah
                    </h3>
                    @if ($rumahTidakLayakHuni->foto_rumah)
                        <a href="{{ asset('storage/' . $rumahTidakLayakHuni->foto_rumah) }}" target="_blank">
                            <img src="{{ asset('storage/' . $rumahTidakLayakHuni->foto_rumah) }}" alt="Foto Rumah"
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

            {{-- SEKSI 4: DOKUMENTASI FOTO KONDISI --}}
            <div class="mt-10 pt-6 border-t border-slate-200">
                <h3 class="text-xl font-semibold text-midnight_green mb-6">
                    Dokumentasi Foto Kondisi
                </h3>
                @php
                    $photoDetails = [
                        'Lantai' => $rumahTidakLayakHuni->foto_kondisi_lantai,
                        'Dinding' => $rumahTidakLayakHuni->foto_kondisi_dinding,
                        'Atap' => $rumahTidakLayakHuni->foto_kondisi_atap,
                        'Sanitasi/WC' => $rumahTidakLayakHuni->foto_sanitasi_wc,
                        'Dapur' => $rumahTidakLayakHuni->foto_kondisi_dapur,
                    ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach ($photoDetails as $label => $photoPath)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Foto {{ $label }}</label>
                            @if ($photoPath)
                                <a href="{{ asset('storage/' . $photoPath) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto {{ $label }}"
                                        class="w-full h-40 rounded-lg shadow-md border border-slate-200 object-cover">
                                </a>
                            @else
                                <div
                                    class="flex items-center justify-center h-40 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300">
                                    <p class="text-slate-500 italic text-sm text-center px-2">Tidak ada foto.</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
