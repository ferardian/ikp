{{-- Pasien Section --}}
<div class="section-container">
    <div class="section-header">
        <span class="section-number">I.</span> DATA PASIEN
    </div>

    <table class="info-table">
        <tbody>
            <tr>
                <th class="label-cell" style="width: 160px;">Nama Pasien</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4">{{ $insiden->pasien->nama }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">No. Rekam Medis</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->pasien->no_rekam_medis }}</td>
                <th class="label-cell" style="width: 100px;">Ruangan</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="color: #64748b;">-</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tanggal Lahir</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->pasien->tanggal_lahir ? $insiden->pasien->tanggal_lahir->translatedFormat('d F Y') : '-' }}</td>
                <th class="label-cell" style="width: 100px;">Umur</th>
                <td class="colon-cell">:</td>
                <td class="value-cell">
                    {{ $insiden->pasien->tanggal_lahir ? $insiden->pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') : '-' }}
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Jenis Kelamin</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tr>
                            <td style="width: 150px;">
                                <span class="dejavu">{!! $insiden->pasien->jenis_kelamin == 'L' ? '&#9745;' : '&#9744;' !!}</span> Laki-laki
                            </td>
                            <td style="width: 150px;">
                                <span class="dejavu">{!! $insiden->pasien->jenis_kelamin == 'P' ? '&#9745;' : '&#9744;' !!}</span> Perempuan
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Kelompok Umur</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tbody>
                            @foreach (\App\Helpers\UsiaHelper::kelompokUsiaData() as $key => $item)
                                @if ($loop->index % 2 === 0)
                                    <tr>
                                @endif
                                        <td style="width: 220px;">
                                            <span class="dejavu">{!! ($insiden->pasien->tanggal_lahir && \App\Helpers\UsiaHelper::getKelompokUsia($insiden->pasien->tanggal_lahir) == $key) ? '&#9745;' : '&#9744;' !!}</span>
                                            {!! $item !!}
                                        </td>
                                @if ($loop->index % 2 === 1 || $loop->last)
                                    @if ($loop->last && $loop->index % 2 === 0)
                                        <td style="width: 220px;"></td>
                                    @endif
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Penanggung Biaya</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    @php
                        $pbName = $insiden->pasien->penanggungBiaya?->jenis_penanggung ?? '';
                        $pbNameLower = strtolower($pbName);
                        $isUmum = str_contains($pbNameLower, 'umum') || str_contains($pbNameLower, 'pribadi') || str_contains($pbNameLower, 'sendiri');
                        $isBpjs = str_contains($pbNameLower, 'bpjs') || str_contains($pbNameLower, 'jkn');
                        $isAsuransi = str_contains($pbNameLower, 'asuransi');
                        $isLainnya = !$isUmum && !$isBpjs && !$isAsuransi && $pbName != '';
                    @endphp
                    <table class="nested-table">
                        <tbody>
                            <tr>
                                <td style="width: 220px;">
                                    <span class="dejavu">{!! $isUmum ? '&#9745;' : '&#9744;' !!}</span> Pribadi
                                </td>
                                <td style="width: 220px;">
                                    <span class="dejavu">{!! $isBpjs ? '&#9745;' : '&#9744;' !!}</span> BPJS
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 220px;">
                                    <span class="dejavu">{!! $isAsuransi ? '&#9745;' : '&#9744;' !!}</span> Asuransi Swasta
                                </td>
                                <td style="width: 220px;">
                                    <span class="dejavu">{!! $isLainnya ? '&#9745;' : '&#9744;' !!}</span> Lainnya : 
                                    @if ($isLainnya)
                                        <span style="border-bottom: 1px dotted #475569; font-weight: bold;">{{ $pbName }}</span>
                                    @else
                                        ............................
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tanggal Masuk RS</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->tgl_pasien_masuk ? $insiden->tgl_pasien_masuk->translatedFormat('d F Y') : '-' }}</td>
                <th class="label-cell" style="width: 100px;">Jam</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="color: #64748b;">-</td>
            </tr>
        </tbody>
    </table>
</div>