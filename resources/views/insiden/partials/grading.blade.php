{{-- Grading Section --}}
<div class="section-container">
    <div class="section-header">
        <span class="section-number">IV.</span> GRADING RISIKO INSIDEN
    </div>

    <table class="info-table">
        <tbody>
            <tr>
                <th class="label-cell" style="width: 160px;">Grading Risiko</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4">
                    @php
                        $badgeColor = match ($insiden->grading?->grading_risiko) {
                            'Biru' => 'background-color: #3b82f6; color: white;',
                            'Hijau' => 'background-color: #22c55e; color: white;',
                            'Kuning' => 'background-color: #eab308; color: #1e293b;',
                            'Merah' => 'background-color: #ef4444; color: white;',
                            default => 'background-color: #64748b; color: white;',
                        };
                    @endphp
                    <span style="padding: 4px 12px; font-weight: bold; border-radius: 4px; font-size: 10pt; {{ $badgeColor }}">
                        {{ $insiden->grading?->grading_risiko ?? 'Belum Di-grading' }}
                    </span>
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Grading Oleh</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4">{{ $insiden->grading?->oleh?->name ?? '-' }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Grading Pada</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->grading?->created_at ? $insiden->grading?->created_at->translatedFormat('d F Y') : '-' }}</td>
                <th class="label-cell" style="width: 100px;">Jam</th>
                <td class="colon-cell">:</td>
                <td class="value-cell">{{ $insiden->grading?->created_at ? $insiden->grading?->created_at->format('H:i') : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>