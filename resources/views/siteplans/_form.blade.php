<div class="card">
    <div class="card-header">
        <strong>Informasi Umum</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama Perumahan:</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Perumahan"
                    value="{{ $siteplan->nama ?? old('nama') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nama_pt" class="form-label">Nama PT:</label>
                <input type="text" name="nama_pt" class="form-control" placeholder="Nama PT"
                    value="{{ $siteplan->nama_pt ?? old('nama_pt') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tipe" class="form-label">Tipe:</label>
                <input type="text" name="tipe" class="form-control" placeholder="Tipe"
                    value="{{ $siteplan->tipe ?? old('tipe') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="jenis" class="form-label">Jenis:</label>
                <input type="text" name="jenis" class="form-control" placeholder="Jenis (e.g., MBR / Komersil)"
                    value="{{ $siteplan->jenis ?? old('jenis') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="jumlah_unit_rumah" class="form-label">Jumlah Unit Rumah:</label>
                <input type="number" name="jumlah_unit_rumah" class="form-control" placeholder="Jumlah Unit"
                    value="{{ $siteplan->jumlah_unit_rumah ?? old('jumlah_unit_rumah') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="tahun" class="form-label">Tahun:</label>
                <input type="number" name="tahun" class="form-control" placeholder="YYYY"
                    value="{{ $siteplan->tahun ?? old('tahun') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="sumber_air_bersih" class="form-label">Sumber Air Bersih:</label>
                <input type="text" name="sumber_air_bersih" class="form-control" placeholder="Sumur Gali/Bor/PDAM"
                    value="{{ $siteplan->sumber_air_bersih ?? old('sumber_air_bersih') }}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="alamat" class="form-label">Alamat (Jalan/RT/RW):</label>
                <textarea class="form-control" style="height:100px" name="alamat" placeholder="Alamat">{{ $siteplan->alamat ?? old('alamat') }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kecamatan" class="form-label">Kecamatan:</label>
                <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan"
                    value="{{ $siteplan->kecamatan ?? old('kecamatan') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="desa" class="form-label">Desa:</label>
                <input type="text" name="desa" class="form-control" placeholder="Desa"
                    value="{{ $siteplan->desa ?? old('desa') }}">
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <strong>Detail Lahan & Prasarana</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="luas_lahan_per_unit" class="form-label">Luas Lahan Per Unit:</label>
                <input type="text" name="luas_lahan_per_unit" class="form-control" placeholder="Contoh: 6x12"
                    value="{{ $siteplan->luas_lahan_per_unit ?? old('luas_lahan_per_unit') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_lahan_perumahan" class="form-label">Luas Lahan Perumahan (m²):</label>
                <input type="number" step="0.01" name="luas_lahan_perumahan" class="form-control"
                    placeholder="0.00" value="{{ $siteplan->luas_lahan_perumahan ?? old('luas_lahan_perumahan') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_psu" class="form-label">Luas PSU (m²):</label>
                <input type="number" step="0.01" name="luas_psu" class="form-control" placeholder="0.00"
                    value="{{ $siteplan->luas_psu ?? old('luas_psu') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="panjang_prasarana_jalan" class="form-label">Panjang Prasarana Jalan (m):</label>
                <input type="number" step="0.01" name="panjang_prasarana_jalan" class="form-control"
                    placeholder="0.00"
                    value="{{ $siteplan->panjang_prasarana_jalan ?? old('panjang_prasarana_jalan') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="lebar_prasarana_jalan" class="form-label">Lebar Prasarana Jalan (m):</label>
                <input type="number" step="0.01" name="lebar_prasarana_jalan" class="form-control"
                    placeholder="0.00"
                    value="{{ $siteplan->lebar_prasarana_jalan ?? old('lebar_prasarana_jalan') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_prasarana_jalan" class="form-label">Luas Prasarana Jalan (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_jalan" class="form-control"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_jalan ?? old('luas_prasarana_jalan') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_prasarana_drainase" class="form-label">Luas Prasarana Drainase (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_drainase" class="form-control"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_prasarana_drainase ?? old('luas_prasarana_drainase') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_prasarana_rth" class="form-label">Luas Prasarana RTH (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_rth" class="form-control"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_rth ?? old('luas_prasarana_rth') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_prasarana_tps" class="form-label">Luas Prasarana TPS (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_tps" class="form-control"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_tps ?? old('luas_prasarana_tps') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_sarana_pemakaman" class="form-label">Luas Sarana Pemakaman (m²):</label>
                <input type="number" step="0.01" name="luas_sarana_pemakaman" class="form-control"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_sarana_pemakaman ?? old('luas_sarana_pemakaman') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="luas_sarana_olahraga_dll" class="form-label">Luas Sarana Olahraga/Lainnya (m²):</label>
                <input type="number" step="0.01" name="luas_sarana_olahraga_dll" class="form-control"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_sarana_olahraga_dll ?? old('luas_sarana_olahraga_dll') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="panjang_utilitas" class="form-label">Panjang Utilitas (m):</label>
                <input type="text" name="panjang_utilitas" class="form-control" placeholder="Listrik, air, dll"
                    value="{{ $siteplan->panjang_utilitas ?? old('panjang_utilitas') }}">
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <strong>Administrasi & Legalitas</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nomor_site_plan" class="form-label">Nomor Site Plan:</label>
                <input type="text" name="nomor_site_plan" class="form-control" placeholder="Nomor Site Plan"
                    value="{{ $siteplan->nomor_site_plan ?? old('nomor_site_plan') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggal_site_plan" class="form-label">Tanggal Site Plan:</label>
                <input type="date" name="tanggal_site_plan" class="form-control"
                    value="{{ $siteplan->tanggal_site_plan ?? null ? $siteplan->tanggal_site_plan->format('Y-m-d') : old('tanggal_site_plan') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomor_bast_adm" class="form-label">Nomor BAST Administrasi:</label>
                <input type="text" name="nomor_bast_adm" class="form-control" placeholder="Nomor BAST Adm"
                    value="{{ $siteplan->nomor_bast_adm ?? old('nomor_bast_adm') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggal_bast_adm" class="form-label">Tanggal BAST Administrasi:</label>
                <input type="date" name="tanggal_bast_adm" class="form-control"
                    value="{{ $siteplan->tanggal_bast_adm ?? null ? $siteplan->tanggal_bast_adm->format('Y-m-d') : old('tanggal_bast_adm') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomor_bast_fisik" class="form-label">Nomor BAST Fisik:</label>
                <input type="text" name="nomor_bast_fisik" class="form-control" placeholder="Nomor BAST Fisik"
                    value="{{ $siteplan->nomor_bast_fisik ?? old('nomor_bast_fisik') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="tanggal_bast_fisik" class="form-label">Tanggal BAST Fisik:</label>
                <input type="date" name="tanggal_bast_fisik" class="form-control"
                    value="{{ $siteplan->tanggal_bast_fisik ?? null ? $siteplan->tanggal_bast_fisik->format('Y-m-d') : old('tanggal_bast_fisik') }}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea class="form-control" name="keterangan" placeholder="Jatuh Tempo/Proses/Selesai">{{ $siteplan->keterangan ?? old('keterangan') }}</textarea>
            </div>
        </div>
    </div>
</div>
