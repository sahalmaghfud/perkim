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

        {{-- Grid Konten Utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri (Detail Utama) --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Card: Detail Pekerjaan & Lokasi --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h4 class="text-xl font-semibold text-midnight_green">
                            <i class="fas fa-road mr-2"></i> Detail Pekerjaan & Lokasi
                        </h4>
                    </div>
                    <div class="p-6 divide-y divide-slate-100">
                        @php
                            $jobDetails = [
                                'Uraian Pekerjaan' => $jalanLingkungan->uraian,
                                'Kecamatan' => $jalanLingkungan->kecamatan,
                                'Desa/Kelurahan' => $jalanLingkungan->desa,
                                'Alamat Lengkap' => $jalanLingkungan->alamat,
                                'Volume' => $jalanLingkungan->volume
                                    ? $jalanLingkungan->volume . ' ' . $jalanLingkungan->satuan
                                    : null,
                            ];
                        @endphp
                        @foreach ($jobDetails as $label => $value)
                            @include('jalan_lingkungan._detail_row', [
                                'label' => $label,
                                'value' => $value,
                            ])
                        @endforeach
                    </div>
                </div>

                {{-- Card: Detail Kontrak & Berita Acara --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h4 class="text-xl font-semibold text-midnight_green">
                            <i class="fas fa-file-signature mr-2"></i> Detail Kontrak & Berita Acara
                        </h4>
                    </div>
                    <div class="p-6 divide-y divide-slate-100">
                        @php
                            $contractDetails = [
                                'Nomor Kontrak' => $jalanLingkungan->nomor_kontrak,
                                'Tanggal Kontrak' => $jalanLingkungan->tanggal_kontrak
                                    ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_kontrak)->translatedFormat(
                                        'd F Y',
                                    )
                                    : null,
                                'Tanggal Awal Pekerjaan' => $jalanLingkungan->tanggal_awal_pekerjaan
                                    ? \Carbon\Carbon::parse($jalanLingkungan->tanggal_awal_pekerjaan)->translatedFormat(
                                        'd F Y',
                                    )
                                    : null,
                                'Tanggal Akhir Pekerjaan' => $jalanLingkungan->tanggal_akhir_pekerjaan
                                    ? \Carbon\Carbon::parse(
                                        $jalanLingkungan->tanggal_akhir_pekerjaan,
                                    )->translatedFormat('d F Y')
                                    : null,
                                'Nomor BAPHP' => $jalanLingkungan->baphp_nomor,
                                'Tanggal BAPHP' => $jalanLingkungan->baphp_tanggal
                                    ? \Carbon\Carbon::parse($jalanLingkungan->baphp_tanggal)->translatedFormat('d F Y')
                                    : null,
                                'Nomor BAST' => $jalanLingkungan->bast_nomor,
                                'Tanggal BAST' => $jalanLingkungan->bast_tanggal
                                    ? \Carbon\Carbon::parse($jalanLingkungan->bast_tanggal)->translatedFormat('d F Y')
                                    : null,
                            ];
                        @endphp
                        @foreach ($contractDetails as $label => $value)
                            @include('jalan_lingkungan._detail_row', [
                                'label' => $label,
                                'value' => $value,
                            ])
                        @endforeach
                    </div>
                </div>

                {{-- Card: Dokumentasi Foto --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h4 class="text-xl font-semibold text-midnight_green">
                            <i class="fas fa-camera-retro mr-2"></i> Dokumentasi Foto
                        </h4>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-semibold text-slate-700 mb-2">Foto Sebelum</h5>
                            @if ($jalanLingkungan->foto_sebelum)
                                <a href="{{ asset('storage/' . $jalanLingkungan->foto_sebelum) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $jalanLingkungan->foto_sebelum) }}" alt="Foto Sebelum"
                                        class="rounded-lg shadow-md w-full h-auto object-cover hover:opacity-90 transition">
                                </a>
                            @else
                                <div class="flex items-center justify-center h-48 bg-slate-100 rounded-lg text-slate-500">
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h5 class="font-semibold text-slate-700 mb-2">Foto Sesudah</h5>
                            @if ($jalanLingkungan->foto_sesudah)
                                <a href="{{ asset('storage/' . $jalanLingkungan->foto_sesudah) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $jalanLingkungan->foto_sesudah) }}" alt="Foto Sesudah"
                                        class="rounded-lg shadow-md w-full h-auto object-cover hover:opacity-90 transition">
                                </a>
                            @else
                                <div class="flex items-center justify-center h-48 bg-slate-100 rounded-lg text-slate-500">
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Keterangan --}}
                @if ($jalanLingkungan->keterangan)
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                        <div class="p-6 border-b border-slate-200">
                            <h4 class="text-xl font-semibold text-midnight_green">
                                <i class="fas fa-info-circle mr-2"></i> Keterangan
                            </h4>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $jalanLingkungan->keterangan }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan (Keuangan & Pencairan) --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Card: Detail Keuangan --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h4 class="text-xl font-semibold text-midnight_green">
                            <i class="fas fa-wallet mr-2"></i> Rincian Keuangan
                        </h4>
                    </div>
                    <div class="p-6 divide-y divide-slate-100">
                        @php
                            $financeDetails = [
                                'Harga Satuan' => $jalanLingkungan->harga_satuan,
                                'Jumlah Harga' => $jalanLingkungan->jumlah_harga,
                                'Nilai Kontrak' => $jalanLingkungan->nilai_kontrak,
                            ];
                        @endphp
                        @foreach ($financeDetails as $label => $value)
                            @include('jalan_lingkungan._detail_row', [
                                'label' => $label,
                                'value' => $value ? 'Rp ' . number_format($value, 2, ',', '.') : null,
                                'isCurrency' => true,
                            ])
                        @endforeach
                    </div>
                </div>

                {{-- Card: Realisasi Pencairan --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <h4 class="text-xl font-semibold text-midnight_green">
                            <i class="fas fa-cash-register mr-2"></i> Realisasi Pencairan
                        </h4>
                    </div>
                    <div class="p-6 space-y-6">
                        @include('jalan_lingkungan._detail_pencairan_card', [
                            'stage' => '30',
                            'title' => 'Tahap 30%',
                        ])
                        @include('jalan_lingkungan._detail_pencairan_card', [
                            'stage' => '95',
                            'title' => 'Tahap 95%',
                        ])
                        @include('jalan_lingkungan._detail_pencairan_card', [
                            'stage' => '100',
                            'title' => 'Tahap 100%',
                        ])
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
