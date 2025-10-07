@extends('layouts.app')

@section('content')
    {{-- Latar belakang utama diubah ke putih --}}
    <div class="bg-white min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <header class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-midnight_green">
                            {{ $siteplan->nama }}
                        </h1>
                        <p class="mt-1 text-md text-slate-500">
                            Oleh <span class="font-semibold text-slate-600">{{ $siteplan->nama_pt }}</span> &bull; Status:
                            <span class="font-semibold text-slate-600">{{ $siteplan->keterangan ?: '-' }}</span>
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('siteplans.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('siteplans.edit', $siteplan->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-midnight_green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-midnight_green-600">
                            Edit
                        </a>
                    </div>
                </div>
            </header>

            {{-- Kartu informasi utama yang sebelumnya ada di sini telah dihapus --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="space-y-8">
                    <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 bg-white border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-midnight_green">Informasi Proyek</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            {{-- Nama Perumahan dipindahkan ke sini --}}
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Nama Perumahan</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->nama }}</dd>
                            </div>
                            {{-- Status dipindahkan ke sini --}}
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Status</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->keterangan ?: '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Kecamatan</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->kecamatan ?: '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Desa</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->desa ?: '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Jenis / Tipe</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->jenis ?: '-' }} /
                                    {{ $siteplan->tipe ?: '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Jumlah Unit</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">
                                    {{ $siteplan->jumlah_unit_rumah ?: '-' }} Unit</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Tahun</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">{{ $siteplan->tahun ?: '-' }}</dd>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 bg-white border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-midnight_green">Detail Lahan</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Luas Lahan per Unit</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">
                                    {{ $siteplan->luas_lahan_per_unit ?: '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Total Luas Lahan</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">
                                    {{ number_format($siteplan->luas_lahan_perumahan, 2, ',', '.') }} m²</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-slate-500">Total Luas PSU</dt>
                                <dd class="col-span-2 text-slate-700 font-semibold">
                                    {{ number_format($siteplan->luas_psu, 2, ',', '.') }} m²</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 bg-white border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-midnight_green">Legalitas & Administrasi</h2>
                        </div>
                        <div class="p-6 divide-y divide-slate-100">
                            {{-- Nama Perusahaan dipindahkan ke sini --}}
                            <div class="py-3">
                                <p class="text-sm text-slate-500">Nama Perusahaan</p>
                                <p class="font-semibold text-slate-700">{{ $siteplan->nama_pt ?: '-' }}</p>
                            </div>
                            <div class="py-3">
                                <p class="text-sm text-slate-500">Nomor Site Plan</p>
                                <p class="font-semibold text-slate-700">{{ $siteplan->nomor_site_plan ?: '-' }}</p>
                                <p class="text-xs text-slate-400 mt-1">Tanggal:
                                    {{ $siteplan->tanggal_site_plan ? \Carbon\Carbon::parse($siteplan->tanggal_site_plan)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div class="py-3">
                                <p class="text-sm text-slate-500">Nomor BAST Administrasi</p>
                                <p class="font-semibold text-slate-700">{{ $siteplan->nomor_bast_adm ?: '-' }}</p>
                                <p class="text-xs text-slate-400 mt-1">Tanggal:
                                    {{ $siteplan->tanggal_bast_adm ? \Carbon\Carbon::parse($siteplan->tanggal_bast_adm)->format('d M Y') : '-' }}
                                </p>
                            </div>
                            <div class="py-3">
                                <p class="text-sm text-slate-500">Nomor BAST Fisik</p>
                                <p class="font-semibold text-slate-700">{{ $siteplan->nomor_bast_fisik ?: '-' }}</p>
                                <p class="text-xs text-slate-400 mt-1">Tanggal:
                                    {{ $siteplan->tanggal_bast_fisik ? \Carbon\Carbon::parse($siteplan->tanggal_bast_fisik)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-white border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-midnight_green">Rincian Prasarana, Sarana, dan Utilitas (PSU)</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Prasarana Jalan</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_prasarana_jalan, 2, ',', '.') }} m²</p>
                        <p class="text-xs text-slate-400 mt-1">P:
                            {{ number_format($siteplan->panjang_prasarana_jalan, 2, ',', '.') }} m / L:
                            {{ number_format($siteplan->lebar_prasarana_jalan, 2, ',', '.') }} m</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Prasarana Drainase</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_prasarana_drainase, 2, ',', '.') }} m²</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Prasarana RTH</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_prasarana_rth, 2, ',', '.') }} m²</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Prasarana TPS</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_prasarana_tps, 2, ',', '.') }} m²</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Sarana Pemakaman</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_sarana_pemakaman, 2, ',', '.') }} m²</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Sarana Olahraga/Lainnya</p>
                        <p class="font-semibold text-slate-700">
                            {{ number_format($siteplan->luas_sarana_olahraga_dll, 2, ',', '.') }} m²</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Panjang Utilitas</p>
                        <p class="font-semibold text-slate-700">{{ $siteplan->panjang_utilitas ?: '-' }}</p>
                    </div>
                    <div class="border-b pb-2">
                        <p class="text-sm text-slate-500">Sumber Air Bersih</p>
                        <p class="font-semibold text-slate-700">{{ $siteplan->sumber_air_bersih ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-white border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-midnight_green">Dokumen Siteplan</h2>
                    </div>
                    <div class="p-4">
                        @if ($siteplan->file_path)
                            <iframe src="{{ Storage::url($siteplan->file_path) }}"
                                class="w-full h-[80vh] rounded-md border" frameborder="0">
                            </iframe>
                        @else
                            {{-- Ikon tetap menggunakan warna slate --}}
                            <div class="text-center py-24 text-slate-500 flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-slate-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="font-semibold">Tidak ada dokumen yang diunggah.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
