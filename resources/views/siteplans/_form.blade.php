{{-- Bagian Informasi Umum --}}
<div class="bg-white shadow-md rounded-lg border border-gray-200">
    <div class="border-b border-gray-200 px-6 py-4">
        <strong class="text-lg font-semibold text-gray-800">Informasi Umum</strong>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 md:col-span-6">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Perumahan:</label>
                <input type="text" name="nama" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nama Perumahan"
                    value="{{ $siteplan->nama ?? old('nama') }}">
            </div>

            <div class="col-span-12 md:col-span-6">
                <label for="nama_pt" class="block text-sm font-medium text-gray-700 mb-1">Nama PT:</label>
                <input type="text" name="nama_pt" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nama PT"
                    value="{{ $siteplan->nama_pt ?? old('nama_pt') }}">
            </div>

            <div class="col-span-12 md:col-span-6">
                <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe:</label>
                <input type="text" name="tipe" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Tipe"
                    value="{{ $siteplan->tipe ?? old('tipe') }}">
            </div>

            <div class="col-span-12 md:col-span-6">
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis:</label>
                <input type="text" name="jenis" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Jenis (e.g., MBR / Komersil)"
                    value="{{ $siteplan->jenis ?? old('jenis') }}">
            </div>

            <div class="col-span-12 md:col-span-4">
                <label for="jumlah_unit_rumah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Unit Rumah:</label>
                <input type="number" name="jumlah_unit_rumah" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Jumlah Unit"
                    value="{{ $siteplan->jumlah_unit_rumah ?? old('jumlah_unit_rumah') }}">
            </div>

            <div class="col-span-12 md:col-span-4">
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun:</label>
                <input type="number" name="tahun" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="YYYY"
                    value="{{ $siteplan->tahun ?? old('tahun') }}">
            </div>

            <div class="col-span-12 md:col-span-4">
                <label for="sumber_air_bersih" class="block text-sm font-medium text-gray-700 mb-1">Sumber Air Bersih:</label>
                <input type="text" name="sumber_air_bersih" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Sumur Gali/Bor/PDAM"
                    value="{{ $siteplan->sumber_air_bersih ?? old('sumber_air_bersih') }}">
            </div>

            <div class="col-span-12">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat (Jalan/RT/RW):</label>
                <textarea class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-24" name="alamat" placeholder="Alamat">{{ $siteplan->alamat ?? old('alamat') }}</textarea>
            </div>

            {{-- DROPDOWN DINAMIS BARU --}}
            <div class="col-span-12 md:col-span-6">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan:</label>
                <select name="kecamatan" id="kecamatan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">Pilih Kecamatan</option>
                    {{-- Opsi Kecamatan akan diisi oleh JavaScript --}}
                </select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <label for="desa" class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan:</label>
                <select name="desa" id="desa" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" disabled>
                    <option value="">Pilih Kecamatan Terlebih Dahulu</option>
                </select>
            </div>
            {{-- AKHIR DROPDOWN DINAMIS BARU --}}
        </div>
    </div>
</div>

{{-- Bagian Detail Lahan & Prasarana --}}
<div class="bg-white shadow-md rounded-lg border border-gray-200 mt-6">
    <div class="border-b border-gray-200 px-6 py-4">
        <strong class="text-lg font-semibold text-gray-800">Detail Lahan & Prasarana</strong>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-4">
                <label for="luas_lahan_per_unit" class="block text-sm font-medium text-gray-700 mb-1">Luas Lahan Per Unit:</label>
                <input type="text" name="luas_lahan_per_unit" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: 6x12"
                    value="{{ $siteplan->luas_lahan_per_unit ?? old('luas_lahan_per_unit') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_lahan_perumahan" class="block text-sm font-medium text-gray-700 mb-1">Luas Lahan Perumahan (m²):</label>
                <input type="number" step="0.01" name="luas_lahan_perumahan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00" value="{{ $siteplan->luas_lahan_perumahan ?? old('luas_lahan_perumahan') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_psu" class="block text-sm font-medium text-gray-700 mb-1">Luas PSU (m²):</label>
                <input type="number" step="0.01" name="luas_psu" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="0.00"
                    value="{{ $siteplan->luas_psu ?? old('luas_psu') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="panjang_prasarana_jalan" class="block text-sm font-medium text-gray-700 mb-1">Panjang Prasarana Jalan (m):</label>
                <input type="number" step="0.01" name="panjang_prasarana_jalan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00"
                    value="{{ $siteplan->panjang_prasarana_jalan ?? old('panjang_prasarana_jalan') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="lebar_prasarana_jalan" class="block text-sm font-medium text-gray-700 mb-1">Lebar Prasarana Jalan (m):</label>
                <input type="number" step="0.01" name="lebar_prasarana_jalan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00"
                    value="{{ $siteplan->lebar_prasarana_jalan ?? old('lebar_prasarana_jalan') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_prasarana_jalan" class="block text-sm font-medium text-gray-700 mb-1">Luas Prasarana Jalan (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_jalan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_jalan ?? old('luas_prasarana_jalan') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_prasarana_drainase" class="block text-sm font-medium text-gray-700 mb-1">Luas Prasarana Drainase (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_drainase" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_prasarana_drainase ?? old('luas_prasarana_drainase') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_prasarana_rth" class="block text-sm font-medium text-gray-700 mb-1">Luas Prasarana RTH (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_rth" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_rth ?? old('luas_prasarana_rth') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_prasarana_tps" class="block text-sm font-medium text-gray-700 mb-1">Luas Prasarana TPS (m²):</label>
                <input type="number" step="0.01" name="luas_prasarana_tps" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00" value="{{ $siteplan->luas_prasarana_tps ?? old('luas_prasarana_tps') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_sarana_pemakaman" class="block text-sm font-medium text-gray-700 mb-1">Luas Sarana Pemakaman (m²):</label>
                <input type="number" step="0.01" name="luas_sarana_pemakaman" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_sarana_pemakaman ?? old('luas_sarana_pemakaman') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="luas_sarana_olahraga_dll" class="block text-sm font-medium text-gray-700 mb-1">Luas Sarana Olahraga/Lainnya (m²):</label>
                <input type="number" step="0.01" name="luas_sarana_olahraga_dll" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00"
                    value="{{ $siteplan->luas_sarana_olahraga_dll ?? old('luas_sarana_olahraga_dll') }}">
            </div>
            <div class="col-span-12 md:col-span-4">
                <label for="panjang_utilitas" class="block text-sm font-medium text-gray-700 mb-1">Panjang Utilitas (m):</label>
                <input type="text" name="panjang_utilitas" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Listrik, air, dll"
                    value="{{ $siteplan->panjang_utilitas ?? old('panjang_utilitas') }}">
            </div>
        </div>
    </div>
</div>

{{-- Bagian Administrasi & Legalitas --}}
<div class="bg-white shadow-md rounded-lg border border-gray-200 mt-6">
    <div class="border-b border-gray-200 px-6 py-4">
        <strong class="text-lg font-semibold text-gray-800">Administrasi & Legalitas</strong>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-6">
                <label for="nomor_site_plan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Site Plan:</label>
                <input type="text" name="nomor_site_plan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nomor Site Plan"
                    value="{{ $siteplan->nomor_site_plan ?? old('nomor_site_plan') }}">
            </div>
            <div class="col-span-12 md:col-span-6">
                <label for="tanggal_site_plan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Site Plan:</label>
                <input type="date" name="tanggal_site_plan" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    value="{{ ($siteplan->tanggal_site_plan ?? null) ? $siteplan->tanggal_site_plan->format('Y-m-d') : old('tanggal_site_plan') }}">
            </div>
            <div class="col-span-12 md:col-span-6">
                <label for="nomor_bast_adm" class="block text-sm font-medium text-gray-700 mb-1">Nomor BAST Administrasi:</label>
                <input type="text" name="nomor_bast_adm" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nomor BAST Adm"
                    value="{{ $siteplan->nomor_bast_adm ?? old('nomor_bast_adm') }}">
            </div>
            <div class="col-span-12 md:col-span-6">
                <label for="tanggal_bast_adm" class="block text-sm font-medium text-gray-700 mb-1">Tanggal BAST Administrasi:</label>
                <input type="date" name="tanggal_bast_adm" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    value="{{ ($siteplan->tanggal_bast_adm ?? null) ? $siteplan->tanggal_bast_adm->format('Y-m-d') : old('tanggal_bast_adm') }}">
            </div>
            <div class="col-span-12 md:col-span-6">
                <label for="nomor_bast_fisik" class="block text-sm font-medium text-gray-700 mb-1">Nomor BAST Fisik:</label>
                <input type="text" name="nomor_bast_fisik" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nomor BAST Fisik"
                    value="{{ $siteplan->nomor_bast_fisik ?? old('nomor_bast_fisik') }}">
            </div>
            <div class="col-span-12 md:col-span-6">
                <label for="tanggal_bast_fisik" class="block text-sm font-medium text-gray-700 mb-1">Tanggal BAST Fisik:</label>
                <input type="date" name="tanggal_bast_fisik" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    value="{{ ($siteplan->tanggal_bast_fisik ?? null) ? $siteplan->tanggal_bast_fisik->format('Y-m-d') : old('tanggal_bast_fisik') }}">
            </div>
            <div class="col-span-12">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan:</label>
                <textarea class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-20" name="keterangan" placeholder="Jatuh Tempo/Proses/Selesai">{{ $siteplan->keterangan ?? old('keterangan') }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK DROPDOWN DINAMIS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        // Data Kecamatan dan Desa/Kelurahan (diambil dari daftar yang Anda berikan)
        const data = {
            "Bahar Selatan": ["Adipura Kencana", "Bukit Jaya", "Bukit Subur", "Mekar Jaya", "Tanjung Baru", "Tanjung Lebar", "Tanjung Mulia", "Tanjung Sari", "Tri Jaya", "Ujung Tanjung"],
            "Bahar Utara": ["Bahar Mulya", "Bukit Mulya", "Markanding", "Matra Manunggal", "Mulya Jaya", "Pinang Tinggi", "Sumber Jaya", "Sumber Mulya", "Sungai Dayo", "Talang Bukit", "Talang Datar"],
            "Jambi Luar Kota": ["Danau Sarang Elang", "Kedemangan", "Maro Sebo", "Mendalo Darat", "Mendalo Indah", "Mendalo Laut", "Muara Pijoan", "Muhajirin", "Pematang Gajah", "Pematang Jering", "Penyengat Olak", "Rengas Bandung", "Sarang Burung", "Sembubuk", "Senaung", "Simpang Limo", "Simpang Sungai Duren", "Sungai Bertam", "Sungai Duren", "Pijoan"],
            "Kumpeh": ["Betung", "Gedong Karya", "Jebus", "Londerang", "Maju Jaya", "Mekar Sari", "Pematang Raman", "Petanang", "Puding", "Pulau Mentaro", "Rantau Panjang", "Rondang", "Seponjen", "Sogo", "Sungai Aur", "Sungai Bungur", "Tanjung"],
            "Kumpeh Ulu": ["Pudak", "Muara Kumpeh", "Kota Karang", "Kasang Lopak Alai", "Kasang Pudak", "Solok", "Sakean", "Lopak Alai", "Tarikan", "Ramin", "Teluk Raya", "Pemunduran", "Sipin Teluk Duren", "Arang Arang", "Sumber Jaya", "Sungai Terap", "Kasang Kumpeh", "Kasang Kota Karang"],
            "Maro Sebo": ["Bakung", "Baru", "Danau Kedap", "Danau Lamo", "Jambi Tulo", "Lubuk Raman", "Muaro Jambi", "Mudung Darat", "Niaso", "Setiris", "Tanjung Katung", "Jambi Kecil"],
            "Mestong": ["Baru", "Ibru", "Muaro Sebapo", "Naga Sari", "Nyogan", "Pelempang", "Pondok Meja", "Sebapo", "Suka Damai", "Suka Maju", "Sungai Landai", "Tanjung Pauh KM.32", "Tanjung Pauh KM.39", "Tanjung Pauh Talang Pelita", "Tempino"],
            "Sekernan": ["Berembang", "Bukit Baling", "Gerunggung", "Kedotan", "Keranggan", "Pematang Pulai", "Pulau Kayu Aro", "Rantau Majo", "Sekernan", "Suak Putat", "Suko Awin Jaya", "Tantan", "Tanjung Lanjut", "Tunas Baru", "Tunas Mudo", "Sengeti"],
            "Sungai Bahar": ["Bakti Mulya", "Berkah", "Bukit Makmur", "Bukit Mas", "Marga Manunggal Jaya", "Marga Mulya", "Mekar Sari Makmur", "Panca Bakti", "Panca Mulya", "Suka Makmur", "Tanjung Harapan"],
            "Sungai Gelam": ["Sungai Gelam", "Gambut Jaya", "Kebon IX", "Ladang Panjang", "Mekar Jaya", "Mingkung Jaya", "Parit", "Petaling Jaya", "Sido Mukti", "Sumber Agung", "Talang Belido", "Talang Kerinci", "Tangkit", "Tangkit Baru", "Trimulya Jaya"],
            "Taman Rajo": ["Dusun Mudo", "Kemingking Dalam", "Kemingking Luar", "Kunangan", "Manis Mato", "Rukam", "Sekumbung", "Talang Duku", "Tebat Patah", "Teluk Jambu"]
        };

        // Mengambil data lama (jika ada, misal saat validasi gagal) atau data dari database
        const oldKecamatan = "{{ $siteplan->kecamatan ?? old('kecamatan') }}";
        const oldDesa = "{{ $siteplan->desa ?? old('desa') }}";

        // 1. Isi dropdown Kecamatan saat halaman dimuat
        for (const kecamatan in data) {
            const option = document.createElement('option');
            option.value = kecamatan;
            option.textContent = kecamatan;
            if (kecamatan === oldKecamatan) {
                option.selected = true;
            }
            kecamatanSelect.appendChild(option);
        }

        // 2. Fungsi untuk mengisi dropdown Desa berdasarkan Kecamatan yang dipilih
        function populateDesa(selectedKecamatan) {
            // Kosongkan opsi desa
            desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
            
            if (selectedKecamatan && data[selectedKecamatan]) {
                desaSelect.disabled = false;
                const desas = data[selectedKecamatan];
                desas.forEach(desa => {
                    const option = document.createElement('option');
                    option.value = desa;
                    option.textContent = desa;
                    if (desa === oldDesa) {
                        option.selected = true;
                    }
                    desaSelect.appendChild(option);
                });
            } else {
                desaSelect.disabled = true;
                desaSelect.innerHTML = '<option value="">Pilih Kecamatan Terlebih Dahulu</option>';
            }
        }

        // 3. Tambahkan event listener ke dropdown Kecamatan
        kecamatanSelect.addEventListener('change', function () {
            populateDesa(this.value);
        });

        // 4. Panggil fungsi populateDesa saat halaman pertama kali dimuat (untuk handle form edit)
        if (oldKecamatan) {
            populateDesa(oldKecamatan);
        }
    });
</script>
