{{--
    File: resources/views/jalan_lingkungan/_detail_pencairan_card.blade.php
    Description: Komponen reusable untuk menampilkan detail per tahap pencairan.
--}}
<div class="border border-slate-200 rounded-lg p-4">
    <h5 class="font-bold text-slate-800 mb-3">{{ $title }}</h5>
    <div class="space-y-2 text-xs">
        @php
            $details = [
                'No. SPM' => $jalanLingkungan->{'no_spm_' . $stage},
                'No. SP2D' => $jalanLingkungan->{'no_sp2d_' . $stage},
                'Tanggal' => $jalanLingkungan->{'tanggal_' . $stage}
                    ? \Carbon\Carbon::parse($jalanLingkungan->{'tanggal_' . $stage})->format('d/m/Y')
                    : null,
                'Nilai' => $jalanLingkungan->{'nilai_' . $stage}
                    ? 'Rp ' . number_format($jalanLingkungan->{'nilai_' . $stage}, 0, ',', '.')
                    : null,
                'PPN' => $jalanLingkungan->{'ppn_' . $stage}
                    ? 'Rp ' . number_format($jalanLingkungan->{'ppn_' . $stage}, 0, ',', '.')
                    : null,
                'PPH' => $jalanLingkungan->{'pph_' . $stage}
                    ? 'Rp ' . number_format($jalanLingkungan->{'pph_' . $stage}, 0, ',', '.')
                    : null,
            ];
            $total = $jalanLingkungan->{'total_' . $stage}
                ? 'Rp ' . number_format($jalanLingkungan->{'total_' . $stage}, 0, ',', '.')
                : null;
        @endphp
        @foreach ($details as $label => $value)
            <div class="flex justify-between items-center">
                <span class="text-slate-600">{{ $label }}</span>
                <span class="font-semibold text-slate-800">{{ $value ?? '—' }}</span>
            </div>
        @endforeach
        <div class="flex justify-between items-center pt-2 border-t border-slate-200 mt-2">
            <span class="text-slate-600 font-bold">Total Diterima</span>
            <span class="font-bold text-emerald-600">{{ $total ?? '—' }}</span>
        </div>
    </div>
</div>
