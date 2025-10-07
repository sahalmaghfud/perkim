{{--
    File: resources/views/jalan_lingkungan/cv/_form.blade.php
    Description: Komponen form parsial untuk data CV (create dan edit).
--}}

@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Nama CV --}}
    <div>
        <label for="nama_cv" class="block text-sm font-medium text-gray-700 mb-1">Nama CV <span
                class="text-red-500">*</span></label>
        <input type="text" name="nama_cv" id="nama_cv" value="{{ old('nama_cv', isset($cv) ? $cv->nama_cv : '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green @error('nama_cv')  @enderror"
            placeholder="Masukkan nama CV" required>
        @error('nama_cv')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- NPWP --}}
    <div>
        <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
        <input type="text" name="npwp" id="npwp" value="{{ old('npwp', isset($cv) ? $cv->npwp : '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green @error('npwp')  @enderror"
            placeholder="Masukkan NPWP">
        @error('npwp')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor Rekening --}}
    <div>
        <label for="nomor_rekening" class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
        <input type="text" name="nomor_rekening" id="nomor_rekening"
            value="{{ old('nomor_rekening', isset($cv) ? $cv->nomor_rekening : '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green @error('nomor_rekening')  @enderror"
            placeholder="Masukkan nomor rekening">
        @error('nomor_rekening')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nama Direktur --}}
    <div>
        <label for="nama_direktur" class="block text-sm font-medium text-gray-700 mb-1">Nama Direktur</label>
        <input type="text" name="nama_direktur" id="nama_direktur"
            value="{{ old('nama_direktur', isset($cv) ? $cv->nama_direktur : '') }}"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-midnight_green focus:border-midnight_green @error('nama_direktur')  @enderror"
            placeholder="Masukkan nama direktur">
        @error('nama_direktur')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
