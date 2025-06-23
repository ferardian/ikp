@if ($recieve_signature)
    <div class="" style="text-align: center;">
        <p>Penerima Laporan</p>
        <img src="{{ $recieve_signature }}" alt="Tanda Tangan" style="max-height: 150px;" />
        <label for="signature">({{ $recieve_signature_by }})</label>
    </div>
@else
    <em>Belum ada tanda tangan.</em>
@endif
