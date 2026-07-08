{{-- Tindakan Section --}}
<div class="section-container">
    <div class="section-header">
        <span class="section-number">III.</span> TINDAKAN PASCA INSIDEN
    </div>

    <table class="info-table">
        <tbody>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Tindakan</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify;">{!! $insiden->tindakan?->content !!}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tindakan Oleh</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4">
                    {{ in_array($insiden->tindakan?->oleh, ['tim', 'petugas']) ? \Str::ucfirst($insiden->tindakan?->oleh) . " : " . $insiden->tindakan?->detail : $insiden->tindakan?->oleh }}
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tindakan Diisi Pada</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->tindakan?->created_at ? $insiden->tindakan?->created_at->translatedFormat('d F Y') : '-' }}</td>
                <th class="label-cell" style="width: 100px;">Jam</th>
                <td class="colon-cell">:</td>
                <td class="value-cell">{{ $insiden->tindakan?->created_at ? $insiden->tindakan?->created_at->format('H:i') : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>