{{--
    File: resources/views/jalan_lingkungan/_pencairan_fields.blade.php
    Description: Komponen reusable untuk field-field realisasi pencairan.
    Variables:
        - $stage: (string) Tahap pencairan ('30', '95', '100').
        - $jalanLingkungan: (object) Model JalanLingkungan (opsional).
--}}

{{-- No. SPM --}}
<div>
    <label for="no_spm_{{ $stage }}" class="block text-sm font-medium text-slate-700">No. SPM</label>
    <input type="text" name="no_spm_{{ $stage }}" id="no_spm_{{ $stage }}"
        value="{{ old('no_spm_' . $stage, $jalanLingkungan->{'no_spm_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- No. SP2D --}}
<div>
    <label for="no_sp2d_{{ $stage }}" class="block text-sm font-medium text-slate-700">No. SP2D</label>
    <input type="text" name="no_sp2d_{{ $stage }}" id="no_sp2d_{{ $stage }}"
        value="{{ old('no_sp2d_' . $stage, $jalanLingkungan->{'no_sp2d_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- Tanggal --}}
<div>
    <label for="tanggal_{{ $stage }}" class="block text-sm font-medium text-slate-700">Tanggal</label>
    <input type="date" name="tanggal_{{ $stage }}" id="tanggal_{{ $stage }}"
        value="{{ old('tanggal_' . $stage, isset($jalanLingkungan->{'tanggal_' . $stage}) ? \Carbon\Carbon::parse($jalanLingkungan->{'tanggal_' . $stage})->format('Y-m-d') : '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- Nilai (Rp) --}}
<div>
    <label for="nilai_{{ $stage }}" class="block text-sm font-medium text-slate-700">Nilai (Rp)</label>
    <input type="number" name="nilai_{{ $stage }}" id="nilai_{{ $stage }}"
        value="{{ old('nilai_' . $stage, $jalanLingkungan->{'nilai_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- PPN (Rp) --}}
<div>
    <label for="ppn_{{ $stage }}" class="block text-sm font-medium text-slate-700">PPN (Rp)</label>
    <input type="number" name="ppn_{{ $stage }}" id="ppn_{{ $stage }}"
        value="{{ old('ppn_' . $stage, $jalanLingkungan->{'ppn_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- PPH (Rp) --}}
<div>
    <label for="pph_{{ $stage }}" class="block text-sm font-medium text-slate-700">PPH (Rp)</label>
    <input type="number" name="pph_{{ $stage }}" id="pph_{{ $stage }}"
        value="{{ old('pph_' . $stage, $jalanLingkungan->{'pph_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>

{{-- Total Diterima (Rp) --}}
<div class="md:col-span-2">
    <label for="total_{{ $stage }}" class="block text-sm font-medium text-slate-700">Total Diterima (Rp)</label>
    <input type="number" name="total_{{ $stage }}" id="total_{{ $stage }}"
        value="{{ old('total_' . $stage, $jalanLingkungan->{'total_' . $stage} ?? '') }}"
        class="mt-1 block w-full input-style">
</div>
