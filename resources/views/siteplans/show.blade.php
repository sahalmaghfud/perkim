@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Detail Siteplan: <span class="text-blue-600">{{ $siteplan->nama }}</span>
        </h1>
        <a href="{{ route('siteplans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Konten Utama dengan Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Kolom Kiri -->
        <div class="flex flex-col gap-8">
            <!-- Card Informasi Umum -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Umum</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Nama Perumahan</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->nama }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Nama PT</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->nama_pt }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Tipe</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->tipe }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Jenis</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->jenis }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Jumlah Unit Rumah</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->jumlah_unit_rumah }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Tahun</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->tahun }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Sumber Air Bersih</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->sumber_air_bersih }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Alamat</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->alamat }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Kecamatan</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->kecamatan }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-600">Desa</span>
                        <span class="text-gray-800 text-right">{{ $siteplan->desa }}</span>
                    </div>
                </div>
            </div>

            <!-- Card Administrasi & Legalitas -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Administrasi & Legalitas</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Nomor Site Plan</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->nomor_site_plan ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Tanggal Site Plan</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->tanggal_site_plan ? $siteplan->tanggal_site_plan->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Nomor BAST Administrasi</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->nomor_bast_adm ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Tanggal BAST Administrasi</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->tanggal_bast_adm ? $siteplan->tanggal_bast_adm->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Nomor BAST Fisik</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->nomor_bast_fisik ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Tanggal BAST Fisik</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->tanggal_bast_fisik ? $siteplan->tanggal_bast_fisik->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Keterangan</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->keterangan ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div>
            <!-- Card Detail Lahan & Prasarana -->
            <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Lahan & Prasarana</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Lahan Per Unit</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->luas_lahan_per_unit ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Lahan Perumahan</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_lahan_perumahan, 2, ',', '.') }} m²</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas PSU</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_psu, 2, ',', '.') }} m²</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Panjang Prasarana Jalan</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->panjang_prasarana_jalan, 2, ',', '.') }} m</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Lebar Prasarana Jalan</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->lebar_prasarana_jalan, 2, ',', '.') }} m</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Prasarana Jalan</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_prasarana_jalan, 2, ',', '.') }} m²</span>
                        </div>
                    </div>
                     <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Prasarana Drainase</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_prasarana_drainase, 2, ',', '.') }} m²</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Prasarana RTH</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_prasarana_rth, 2, ',', '.') }} m²</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Prasarana TPS</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_prasarana_tps, 2, ',', '.') }} m²</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Sarana Pemakaman</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_sarana_pemakaman, 2, ',', '.') }} m²</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Luas Sarana Olahraga/Lainnya</span>
                            <span class="text-gray-800 text-right">{{ number_format($siteplan->luas_sarana_olahraga_dll, 2, ',', '.') }} m²</span>
                        </div>
                    </div>
                     <div class="p-6">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold text-gray-600">Panjang Utilitas</span>
                            <span class="text-gray-800 text-right">{{ $siteplan->panjang_utilitas ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
