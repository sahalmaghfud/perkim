@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
    {{-- Header Halaman --}}
    <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
        <i class="fas fa-eye absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold tracking-tight">
                    Detail Aset
                </h3>
                <p class="mt-1 text-midnight_green-100/80 text-sm">Informasi lengkap untuk: {{ $aset->nama_barang }}</p>
            </div>
            <a href="{{ route('asets.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </div>

    {{-- Konten Detail --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Foto --}}
            <div class="lg:col-span-1">
                @if ($aset->foto_barang)
                    <img src="{{ asset('storage/' . $aset->foto_barang) }}"
                        class="w-full rounded-lg shadow-md aspect-square object-cover" alt="{{ $aset->nama_barang }}">
                @else
                    <div class="w-full aspect-square bg-slate-100 rounded-lg flex items-center justify-center border">
                        <div class="text-center text-slate-400">
                            <i class="fas fa-image text-4xl"></i>
                            <p class="mt-2 text-sm">Tidak ada foto</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Detail --}}
            <div class="lg:col-span-2">

                {{-- Detail Umum --}}
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                    <i class="fas fa-info-circle mr-2 text-midnight_green-400"></i>
                    Informasi Umum
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-600 w-1/3">Kode Barang</span>
                        <span class="font-mono text-slate-800 text-right w-2/3">{{ $aset->kode_barang ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-600 w-1/3">Jenis KIB</span>
                        <span
                            class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">{{ $aset->jenis_kib }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-600 w-1/3">Tahun Perolehan</span>
                        <span class="text-slate-800 text-right w-2/3">{{ $aset->tahun_perolehan ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-600 w-1/3">Nilai Perolehan</span>
                        <span class="text-slate-800 text-right w-2/3">Rp
                            {{ number_format($aset->nilai_perolehan_rp, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-600 w-1/3">Spesifikasi</span>
                        <p class="text-slate-800 text-right w-2/3">{{ $aset->spesifikasi_barang ?: '-' }}</p>
                    </div>
                </div>

                {{-- Detail Spesifik berdasarkan KIB --}}

                {{-- KIB A: TANAH --}}
                @if ($aset->jenis_kib == 'A')
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                            <i class="fas fa-map-marked-alt mr-2 text-midnight_green-400"></i>
                            Detail Tanah
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between"><span
                                    class="font-semibold text-slate-600 w-1/3">Luas</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->luas ? number_format($aset->luas, 2, ',', '.') . ' M²' : '-' }}</span>
                            </div>
                            <div class="flex justify-between"><span
                                    class="font-semibold text-slate-600 w-1/3">Alamat</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->lokasi_alamat ?: '-' }}</span></div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Status
                                    Hak</span><span class="text-slate-800 text-right w-2/3">{{ $aset->hak ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Nomor
                                    Sertifikat</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->nomor_sertifikat ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Tanggal
                                    Sertifikat</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->tanggal_sertifikat ? \Carbon\Carbon::parse($aset->tanggal_sertifikat)->format('d M Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- KIB B, C, D, G, H: PENYUSUTAN --}}
                @if (in_array($aset->jenis_kib, ['B', 'C', 'D', 'G', 'H']))
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                            <i class="fas fa-chart-line mr-2 text-midnight_green-400"></i>
                            Detail Penyusutan
                        </h3>
                        <div class="space-y-3 text-sm">
                            @if (in_array($aset->jenis_kib, ['C', 'D']))
                                <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Umur
                                        Ekonomis</span><span
                                        class="text-slate-800 text-right w-2/3">{{ $aset->umur_ekonomis_tahun ? $aset->umur_ekonomis_tahun . ' Tahun' : '-' }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Akumulasi
                                    Penyusutan Awal</span><span class="text-slate-800 text-right w-2/3">Rp
                                    {{ number_format($aset->akumulasi_penyusutan_awal, 2, ',', '.') }}</span></div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Beban
                                    Penyusutan Tahunan</span><span class="text-slate-800 text-right w-2/3">Rp
                                    {{ number_format($aset->beban_penyusutan_tahunan, 2, ',', '.') }}</span></div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Akumulasi
                                    Penyusutan Akhir</span><span class="text-slate-800 text-right w-2/3">Rp
                                    {{ number_format($aset->akumulasi_penyusutan_akhir, 2, ',', '.') }}</span></div>
                            <div class="flex justify-between font-bold">
                                <span class="text-slate-600 w-1/3">Nilai Buku</span>
                                <span class="text-slate-800 text-right w-2/3">Rp
                                    {{ number_format($aset->nilai_buku, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- KIB A & F: REGISTRASI --}}
                @if (in_array($aset->jenis_kib, ['A', 'F']))
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                            <i class="fas fa-clipboard-list mr-2 text-midnight_green-400"></i>
                            Detail Registrasi
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Nomor
                                    Induk</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->nomor_induk_barang ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Nomor
                                    Register</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->nomor_register ?: '-' }}</span></div>
                            <div class="flex justify-between"><span class="font-semibold text-slate-600 w-1/3">Cara
                                    Perolehan</span><span
                                    class="text-slate-800 text-right w-2/3">{{ $aset->cara_perolehan ?: '-' }}</span></div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
