@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detail Siteplan: {{ $siteplan->nama }}</h2>
                <a class="btn btn-primary" href="{{ route('siteplans.index') }}"> Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>Informasi Umum</strong></div>
                <div class="card-body">
                    <p><strong>Nama Perumahan:</strong> {{ $siteplan->nama }}</p>
                    <p><strong>Nama PT:</strong> {{ $siteplan->nama_pt }}</p>
                    <p><strong>Tipe:</strong> {{ $siteplan->tipe }}</p>
                    <p><strong>Jenis:</strong> {{ $siteplan->jenis }}</p>
                    <p><strong>Jumlah Unit Rumah:</strong> {{ $siteplan->jumlah_unit_rumah }}</p>
                    <p><strong>Tahun:</strong> {{ $siteplan->tahun }}</p>
                    <p><strong>Sumber Air Bersih:</strong> {{ $siteplan->sumber_air_bersih }}</p>
                    <p><strong>Alamat:</strong> {{ $siteplan->alamat }}</p>
                    <p><strong>Kecamatan:</strong> {{ $siteplan->kecamatan }}</p>
                    <p><strong>Desa:</strong> {{ $siteplan->desa }}</p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header"><strong>Administrasi & Legalitas</strong></div>
                <div class="card-body">
                    <p><strong>Nomor Site Plan:</strong> {{ $siteplan->nomor_site_plan }}</p>
                    <p><strong>Tanggal Site Plan:</strong>
                        {{ $siteplan->tanggal_site_plan ? $siteplan->tanggal_site_plan->format('d M Y') : '-' }}</p>
                    <hr>
                    <p><strong>Nomor BAST Administrasi:</strong> {{ $siteplan->nomor_bast_adm }}</p>
                    <p><strong>Tanggal BAST Administrasi:</strong>
                        {{ $siteplan->tanggal_bast_adm ? $siteplan->tanggal_bast_adm->format('d M Y') : '-' }}</p>
                    <hr>
                    <p><strong>Nomor BAST Fisik:</strong> {{ $siteplan->nomor_bast_fisik }}</p>
                    <p><strong>Tanggal BAST Fisik:</strong>
                        {{ $siteplan->tanggal_bast_fisik ? $siteplan->tanggal_bast_fisik->format('d M Y') : '-' }}</p>
                    <hr>
                    <p><strong>Keterangan:</strong> {{ $siteplan->keterangan }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>Detail Lahan & Prasarana</strong></div>
                <div class="card-body">
                    <p><strong>Luas Lahan Per Unit:</strong> {{ $siteplan->luas_lahan_per_unit }}</p>
                    <p><strong>Luas Lahan Perumahan:</strong>
                        {{ number_format($siteplan->luas_lahan_perumahan, 2, ',', '.') }} m²</p>
                    <p><strong>Luas PSU:</strong> {{ number_format($siteplan->luas_psu, 2, ',', '.') }} m²</p>
                    <hr>
                    <p><strong>Panjang Prasarana Jalan:</strong>
                        {{ number_format($siteplan->panjang_prasarana_jalan, 2, ',', '.') }} m</p>
                    <p><strong>Lebar Prasarana Jalan:</strong>
                        {{ number_format($siteplan->lebar_prasarana_jalan, 2, ',', '.') }} m</p>
                    <p><strong>Luas Prasarana Jalan:</strong>
                        {{ number_format($siteplan->luas_prasarana_jalan, 2, ',', '.') }} m²</p>
                    <hr>
                    <p><strong>Luas Prasarana Drainase:</strong>
                        {{ number_format($siteplan->luas_prasarana_drainase, 2, ',', '.') }} m²</p>
                    <p><strong>Luas Prasarana RTH:</strong> {{ number_format($siteplan->luas_prasarana_rth, 2, ',', '.') }}
                        m²</p>
                    <p><strong>Luas Prasarana TPS:</strong> {{ number_format($siteplan->luas_prasarana_tps, 2, ',', '.') }}
                        m²</p>
                    <hr>
                    <p><strong>Luas Sarana Pemakaman:</strong>
                        {{ number_format($siteplan->luas_sarana_pemakaman, 2, ',', '.') }} m²</p>
                    <p><strong>Luas Sarana Olahraga/Lainnya:</strong>
                        {{ number_format($siteplan->luas_sarana_olahraga_dll, 2, ',', '.') }} m²</p>
                    <hr>
                    <p><strong>Panjang Utilitas:</strong> {{ $siteplan->panjang_utilitas }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
