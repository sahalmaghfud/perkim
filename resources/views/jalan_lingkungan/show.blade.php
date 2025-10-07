@extends('layouts.app')

@section('title', 'Detail Pekerjaan Jalan Lingkungan')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header Halaman --}}
        <div class="relative bg-midnight_green-500 text-white rounded-2xl shadow-xl p-6 overflow-hidden mb-8">
            <i
                class="fas fa-info-circle absolute -right-4 -bottom-8 text-midnight_green-300/30 text-9xl transform rotate-[-15deg]"></i>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        Detail Pekerjaan
                    </h3>
                    <p class="mt-1 text-midnight_green-900/80 text-sm truncate" title="{{ $jalanLingkungan->uraian }}">
                        Rincian untuk: {{ $jalanLingkungan->uraian }}
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('jalan_lingkungan.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white/90 border border-transparent rounded-md font-semibold text-xs text-midnight_green-600 uppercase tracking-widest shadow-sm hover:bg-white transition">
                        Kembali
                    </a>
                    <a href="{{ route('jalan_lingkungan.edit', $jalanLingkungan->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-ecru-300 border border-transparent rounded-md font-semibold text-xs text-ecru-900 uppercase tracking-widest shadow-sm hover:bg-ecru-400 transition">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        {{-- Konten Detail --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-slate-200">

            {{-- SEKSI 1: RINCIAN PEKERJAAN & KEUANGAN --}}
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                    Rincian Pekerjaan & Keuangan
                </h3>
                <div class="divide-y divide-slate-200">
                    @php
                        $details = [
                            'Uraian Pekerjaan' => $jalanLingkungan->uraian,
                            'Volume' => $jalanLingkungan->volume . ' ' . $jalanLingkungan->satuan,
                            'Harga Satuan' => 'Rp ' . number_format($jalanLingkungan->harga_satuan, 0, ',', '.'),
                            'Jumlah Harga' => 'Rp ' . number_format($jalanLingkungan->jumlah_harga, 0, ',', '.'),
                        ];
                    @endphp
                    @foreach ($details as $label => $value)
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center py-3">
                            <span class="text-sm font-medium text-slate-600 w-full sm:w-1/3">{{ $label }}</span>
                            <span
                                class="text-sm text-slate-900 font-semibold text-left sm:text-right w-full sm:w-2/3">{{ $value ?? '—' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SEKSI 2: DETAIL KONTRAK --}}
            <div>
                <h3 class="text-xl font-semibold text-midnight_green border-b border-slate-200 pb-4 mb-4">
                    Detail Kontrak
                </h3>
                <div class="divide-y divide-slate-200">
                    @php
                        $contractDetails = [
                            'CV Pelaksana' => $jalanLingkungan->cv->nama_cv ?? 'N/A',
                            'Nomor Kontrak' => $jalanLingkungan->nomor_kontrak,
                            'Tanggal Kontrak' => $jalanLingkungan->tanggal_kontrak
                                ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_kontrak)->translatedFormat('d F Y')
                                : null,
                            'Nilai Kontrak' => $jalanLingkungan->nilai_kontrak
                                ? 'Rp ' . number_format($jalanLingkungan->nilai_kontrak, 0, ',', '.')
                                : null,
                            'Tanggal Awal Pekerjaan' => $jalanLingkungan->tanggal_awal_pekerjaan
                                ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_awal_pekerjaan)->translatedFormat(
                                    'd F Y',
                                )
                                : null,
                            'Tanggal Akhir Pekerjaan' => $jalanLingkungan->tanggal_akhir_pekerjaan
                                ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_akhir_pekerjaan)->translatedFormat(
                                    'd F Y',
                                )
                                : null,
                            'Keterangan' => $jalanLingkungan->keterangan,
                        ];
                    @endphp
                    @foreach ($contractDetails as $label => $value)
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center py-3">
                            <span class="text-sm font-medium text-slate-600 w-full sm:w-1/3">{{ $label }}</span>
                            <span
                                class="text-sm text-slate-900 font-semibold text-left sm:text-right w-full sm:w-2/3">{{ $value ?? '—' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
