@if ($insiden->investigasi_sederhana)
    <div class="page-break"></div>
    
    {{-- Investigasi Sederhana --}}
    <div class="section-container">
        <div style="margin-bottom: 20px;">
            <h1 class="section-header-large" style="margin-bottom: 4px;">LAPORAN INVESTIGASI SEDERHANA</h1>
            <h2 style="font-size: 11pt; text-align: center; color: #475569; font-weight: normal;">(SIMPLE INVESTIGATION REPORT)</h2>
        </div>

        <table class="info-table">
            <tbody>
                <tr>
                    <th class="label-cell" style="width: 240px;">Manager / Kabag / Kepala Unit</th>
                    <td class="colon-cell">:</td>
                    <td class="value-cell" colspan="4">{{ $insiden->investigasi_sederhana?->kepala?->name }}</td>
                </tr>
                <tr>
                    <th class="label-cell" style="width: 240px; vertical-align: top;">Penyebab Insiden Langsung</th>
                    <td class="colon-cell" style="vertical-align: top;">:</td>
                    <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify;">{{ $insiden->investigasi_sederhana?->penyebab_insiden }}</td>
                </tr>
                <tr>
                    <th class="label-cell" style="width: 240px; vertical-align: top;">Penyebab yang Melatarbelakangi</th>
                    <td class="colon-cell" style="vertical-align: top;">:</td>
                    <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify;">{{ $insiden->investigasi_sederhana?->penyebab_melatarbelakangi }}</td>
                </tr>

                <tr>
                    <td colspan="6" style="padding: 15px 0 5px 0;">
                        <div style="font-weight: bold; color: #1e3a8a; border-bottom: 1.5px solid #cbd5e1; padding-bottom: 4px; font-size: 11pt;">REKOMENDASI & TINDAKAN</div>
                    </td>
                </tr>

                <tr>
                    <th class="label-cell" style="width: 240px; vertical-align: top;">Rekomendasi</th>
                    <td class="colon-cell" style="vertical-align: top;">:</td>
                    <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify;">{!! $insiden->investigasi_sederhana?->rekomendasi !!}</td>
                </tr>
                <tr>
                    <th class="label-cell" style="width: 240px;">Direkomendasikan Oleh</th>
                    <td class="colon-cell">:</td>
                    <td class="value-cell" style="width: 200px;">{{ $insiden->investigasi_sederhana?->pj_rekomendasi?->name }}</td>
                    <th class="label-cell" style="width: 80px;">Tanggal</th>
                    <td class="colon-cell">:</td>
                    <td class="value-cell">{{ $insiden->investigasi_sederhana?->tanggal_rekomendasi ? $insiden->investigasi_sederhana?->tanggal_rekomendasi->translatedFormat('d F Y') : '-' }}</td>
                </tr>

                <tr>
                    <th class="label-cell" style="width: 240px; vertical-align: top;">Tindakan Rekomendasi</th>
                    <td class="colon-cell" style="vertical-align: top;">:</td>
                    <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify;">{!! $insiden->investigasi_sederhana?->tindakan_rekomendasi !!}</td>
                </tr>
                <tr>
                    <th class="label-cell" style="width: 240px;">Ditindak Lanjuti Oleh</th>
                    <td class="colon-cell">:</td>
                    <td class="value-cell" style="width: 200px;">{{ $insiden->investigasi_sederhana?->pj_tindakan?->name }}</td>
                    <th class="label-cell" style="width: 80px;">Tanggal</th>
                    <td class="colon-cell">:</td>
                    <td class="value-cell">{{ $insiden->investigasi_sederhana?->tanggal_tindakan ? $insiden->investigasi_sederhana?->tanggal_tindakan->translatedFormat('d F Y') : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div> 
@endif