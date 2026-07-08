{{-- Insiden Section --}}
<div class="section-container">
    <div class="section-header">
        <span class="section-number">II.</span> RINCIAN KEJADIAN
    </div>

    <table class="info-table">
        <tbody>
            <tr>
                <th class="label-cell" style="width: 160px;">Insiden</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" colspan="4" style="font-weight: bold; color: #1e3a8a;">{{ $insiden->insiden }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tanggal Kejadian</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->tanggal_insiden ? $insiden->tanggal_insiden->translatedFormat('d F Y') : '-' }}</td>
                <th class="label-cell" style="width: 100px;">Jam</th>
                <td class="colon-cell">:</td>
                <td class="value-cell">{{ $insiden->waktu_insiden }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px;">Tempat Kejadian</th>
                <td class="colon-cell">:</td>
                <td class="value-cell" style="width: 200px;">{{ $insiden->tempat_kejadian }}</td>
                <th class="label-cell" style="width: 100px;">Unit Kerja</th>
                <td class="colon-cell">:</td>
                <td class="value-cell">{{ $insiden->unit?->nama_unit }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Kronologi Kejadian</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4" style="line-height: 1.6; text-align: justify; padding-bottom: 10px;">{{ $insiden->kronologi }}</td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Jenis Insiden</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tbody>
                            @foreach ([
                                'KNC'      => 'Kejadian Nyaris Cedera / (Near miss)',
                                'KTD'      => 'Kejadian Tidak diharapkan / (Adverse Event)',
                                'SENTINEL' => 'Kejadian Sentinel / (Sentinel Event)',
                                'KTC'      => 'Kejadian Tidak Cedera / (Non-Sentinel Event)',
                                'KPC'      => 'Kejadian Potensial Cedera / (Potential Event)'
                            ] as $key => $item)
                                @php $isJenis = $insiden->jenis?->alias == $key; @endphp
                                <tr>
                                    <td>
                                        <span class="{{ $isJenis ? 'dejavu-checked' : 'dejavu-unchecked' }}">{!! $isJenis ? '&#9745;' : '&#9744;' !!}</span> {!! $item !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="label-cell" style="width: 160px; vertical-align: top;">Pelapor Pertama</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tbody>
                            @foreach ([
                                'karyawan'   => 'Karyawan (Dokter, Perawat, dll)',
                                'pengunjung' => 'Pengunjung',
                                'pasien'     => 'Pasien',
                                'keluarga'   => 'Keluarga / Pendamping Pasien',
                                'lainnya'    => 'Lainnya : ' . ($insiden->jenis_pelapor_lainnya ? $insiden->jenis_pelapor_lainnya : '................................................')
                            ] as $key => $item)
                                @if ($loop->index % 2 === 0)
                                    <tr>
                                @endif
                                        @php $isPelapor = $insiden->jenis_pelapor == $key; @endphp
                                        <td style="width: 220px;">
                                            <span class="{{ $isPelapor ? 'dejavu-checked' : 'dejavu-unchecked' }}">{!! $isPelapor ? '&#9745;' : '&#9744;' !!}</span> {!! $item !!}
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
                <th class="label-cell" style="width: 160px; vertical-align: top;">Layanan Terkait</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tbody>
                            @foreach ([
                                'ranap'   => 'Rawat Inap',
                                'ralan'   => 'Rawat Jalan',
                                'ugd'     => 'UGD',
                                'lainnya' => 'Lainnya : ' . ($insiden->layanan_insiden_lainnya ? $insiden->layanan_insiden_lainnya : '................................................')
                            ] as $key => $item)
                                @if ($loop->index % 2 === 0)
                                    <tr>
                                @endif
                                        @php $isLayanan = $insiden->layanan_insiden == $key; @endphp
                                        <td style="width: 220px;">
                                            <span class="{{ $isLayanan ? 'dejavu-checked' : 'dejavu-unchecked' }}">{!! $isLayanan ? '&#9745;' : '&#9744;' !!}</span> {!! $item !!}
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
                <th class="label-cell" style="width: 160px; vertical-align: top;">Kategori Kasus</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    @php
                        $kasus = $insiden->kasus_insiden ? array_map(function($item) {
                            return str_replace('-', ' ', $item);
                        }, $insiden->kasus_insiden) : [];
                    @endphp
                    <table class="nested-table">
                        <tbody>
                            @foreach ([
                                'Penyakit Dalam dan Subspesialiasinya',
                                'Anak dan Subspesialiasinya',
                                'Bedah dan Subspesialiasinya',
                                'Obstetri Gynekologi dan Subspesialiasinya',
                                'THT dan Subspesialiasinya',
                                'Mata dan Subspesialiasinya',
                                'Saraf dan Subspesialiasinya',
                                'Anastesi dan Subspesialiasinya',
                                'Kulit & Kelamin dan Subspesialiasinya',
                                'Jantung dan Subspesialiasinya',
                                'Paru dan Subspesialiasinya',
                                'Jiwa dan Subspesialiasinya',
                                'Orthopedi dan Subspesialiasinya'
                            ] as $item)
                                @if ($loop->index % 2 === 0)
                                    <tr>
                                @endif
                                        @php $isKasus = in_array($item, $kasus); @endphp
                                        <td style="width: 220px; padding: 2px 0;">
                                            <span class="{{ $isKasus ? 'dejavu-checked' : 'dejavu-unchecked' }}">{!! $isKasus ? '&#9745;' : '&#9744;' !!}</span> {!! $item !!}
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
                <th class="label-cell" style="width: 160px; vertical-align: top;">Dampak Terhadap Pasien</th>
                <td class="colon-cell" style="vertical-align: top;">:</td>
                <td class="value-cell" colspan="4">
                    <table class="nested-table">
                        <tbody>
                            @foreach ([
                                'katastropik'      => 'Kematian',
                                'mayor'            => 'Cedera Irriversibel / Berat',
                                'moderat'          => 'Cedera Reversibel / Sedang',
                                'minor'            => 'Cedera Ringan',
                                'tidak signifikan' => 'Tidak Cedera',
                            ] as $key => $item)
                                @php $isDampak = $insiden->dampak_insiden == $key; @endphp
                                <tr>
                                    <td>
                                        <span class="{{ $isDampak ? 'dejavu-checked' : 'dejavu-unchecked' }}">{!! $isDampak ? '&#9745;' : '&#9744;' !!}</span> {!! $item !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>