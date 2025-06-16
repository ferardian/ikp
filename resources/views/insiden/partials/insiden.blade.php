{{-- Insiden Section --}}
<div class="mb-8">
    <table class="table w-full">
        <tr>
            <td style="width: 30px;"><p class="text-lg">II.</p></td>
            <td><p class="text-lg">RINCIAN KEJADIAN</p></td>
        </tr>
    </table>

    <div class="ml-8 mt-1">
        <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
            <tbody>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Insiden</th>
                    <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->insiden }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Kejadian</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->tanggal_insiden->translatedFormat('d F Y') }}</td>
                    <th class="text-left leading-none py-2 m-0" style="width: 10px;">Jam</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->waktu_insiden }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tempat Kejadian</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->tempat_kejadian }}</td>
                    <th class="text-left leading-none py-2 m-0">Unit</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->unit->nama_unit }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Kronologi Kejadian</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>{{ $insiden->kronologi }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Jenis Insiden</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>
                                    @foreach ([
                                        'KNC'      => 'Kejadian Nyaris Cedera / (Near miss)',
                                        'KTD'      => 'Kejadian Tidak diharapkan / (Adverse Event)',
                                        'SENTINEL' => 'Kejadian Sentinel / (Sentinel Event)',
                                        'KTC'      => 'Kejadian Tidak Cedera / (Non-Sentinel Event)',
                                        'KPC'      => 'Kejadian Potensial Cedera / (Potential Event)'
                                    ] as $key => $item)
                                        <p><span class="dejavu pr-1">{!! $insiden->jenis->alias == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Orang Pertama Yang Melaporkan</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>
                                    @foreach ([
                                        'karyawan'   => 'Karyawan (Dokter, Perawat, dll)',
                                        'pengunjung' => 'Pengunjung',
                                        'pasien'     => 'Pasien',
                                        'keluarga'   => 'Keluarga / Pendamping Pasien',
                                        'lainnya'    => 'Lainnya : ' . ($insiden->jenis_pelapor_lainnya ? $insiden->jenis_pelapor_lainnya : '..................................................................................... ( sebutkan )')
                                    ] as $key => $item)
                                        <p><span class="dejavu pr-1">{!! $insiden->jenis_pelapor == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Insiden Menyangkut Pasien</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>
                                    @foreach ([
                                        'ranap'   => 'Rawat Inap',
                                        'ralan'   => 'Rawat Jalan',
                                        'ugd'     => 'UGD',
                                        'lainnya' => 'Lainnya : ' . ($insiden->layanan_insiden_lainnya ? $insiden->layanan_insiden_lainnya : '..................................................................................... ( sebutkan )')
                                    ] as $key => $item)
                                        <p><span class="dejavu pr-1">{!! $insiden->layanan_insiden == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Insiden terjadi pada pasien</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        @php
                            $kasus = $insiden->kasus_insiden ? array_map(function($item) {
                                return str_replace('-', ' ', $item);
                            }, $insiden->kasus_insiden) : [];
                        @endphp

                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>
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
                                    ] as $key => $item)
                                        <p><span class="dejavu pr-1">{!! in_array($item, $kasus) ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Dampak Insiden Terhadap Pasien</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>
                                    @foreach ([
                                        'katastropik'      => 'Kematian',
                                        'mayor'            => 'Cedera Irriversibel / Berat',
                                        'moderat'          => 'Cedera Reversibel / Sedang',
                                        'minor'            => 'Cedera Ringan',
                                        'tidak signifikan' => 'Tidak Cedera',
                                    ] as $key => $item)
                                        <p><span class="dejavu pr-1">{!! $insiden->dampak_insiden == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>