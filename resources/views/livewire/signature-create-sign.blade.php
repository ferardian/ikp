@if ($signature)
    <div class="" style="text-align: center;">
        <p>Pembuat Laporan</p>
        <img src="{{ $signature }}" alt="Tanda Tangan" style="max-height: 150px;" />
        <label for="signature">({{ $signatured_by }})</label>
    </div>
@else
    <em>Belum ada tanda tangan.</em>
@endif
