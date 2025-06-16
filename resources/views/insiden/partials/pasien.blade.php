{{-- Pasien Section --}}
<div class="mb-8">
    <table class="table w-full">
        <tr>
            <td style="width: 30px;"><p class="text-lg">I.</p></td>
            <td><p class="text-lg">DATA PASIEN</p></td>
        </tr>
    </table>

    <div class="ml-8 mt-1">
        <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
            <tbody>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Nama Pasien</th>
                    <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->pasien->nama }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">No. Rekam Medis</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->pasien->no_rekam_medis }}</td>
                    <th class="text-left leading-none py-2 m-0">Ruangan</th>
                    <td class="leading-none py-2 m-0">: </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Lahir</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->translatedFormat('d F Y') }}</td>
                    <th class="text-left leading-none py-2 m-0">Umur</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Jenis Kelamin</th>
                    <td class="leading-none py-2 m-0" colspan="3"> 
                        <table class="w-fit">
                            <tr>
                                <td style="width: 7px;">:</td>
                                <td style="width: 200px;"><p><span class="dejavu pr-1">{!! $insiden->pasien->jenis_kelamin == 'L' ? '&#9745;' : '&#9744;' !!}</span> Laki-laki</p></td>
                                <td style="width: 200px;"><p><span class="dejavu pr-1">{!! $insiden->pasien->jenis_kelamin == 'P' ? '&#9745;' : '&#9744;' !!}</span> Perempuan</p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0"  style="width: 150px;">Kelompok Umur</th>
                    <td class="leading-none py-2 m-0" colspan="3"> 
                        <table class="table-auto">
                            <tbody>
                                @foreach (\App\Helpers\UsiaHelper::kelompokUsiaData() as $key => $item)
                                    @if ($loop->index % 2 === 0)
                                        <tr>
                                    @endif
                                            <td style="width: 200px">
                                                <p>
                                                    {{ $loop->first ? ':' : '' }} 
                                                    <span class="dejavu pr-1 {{ !$loop->first ? 'ml-2' : '' }} ">{!! \App\Helpers\UsiaHelper::getKelompokUsia($insiden->pasien->tanggal_lahir) == $key ? '&#9745;' : '&#9744;' !!}</span>
                                                    {!! $item !!}
                                                </p>
                                            </td>
                                    @if ($loop->index % 2 === 1 || $loop->last)
                                        @if ($loop->last && $loop->index % 2 === 0)
                                            <td style="width: 200px"></td>
                                        @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0"  style="width: 150px;">Penanggung Biaya Pasien</th>
                    <td class="leading-none py-2 m-0" colspan="3"> 
                        <table class="w-fit">
                            @foreach ([
                                'pribadi'         => 'Pribadi',
                                'bpjs'            => 'BPJS',
                                'asuransi_swasta' => 'Asuransi Swasta',
                                'lainnya'         => 'Lainnya : ............................ ( sebutkan )'
                            ] as $key => $item)
                                @if ($loop->index % 2 === 0)
                                    <tr>
                                @endif
                                        <td style="width: {{ $loop->index % 2 === 0 ? '200px' : '300px' }}">
                                            <p>
                                                {{ $loop->first ? ':' : '' }} 
                                                <span class="dejavu pr-1 {{ !$loop->first ? 'ml-2' : '' }} ">{!! '&#9744;' !!}</span>
                                                {!! $item !!}
                                            </p>
                                        </td>
                                @if ($loop->index % 2 === 1 || $loop->last)
                                    @if ($loop->last && $loop->index % 2 === 0)
                                        <td style="width: 200px"></td>
                                    @endif
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr class="align-top">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Masuk RS</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->tgl_pasien_masuk->translatedFormat('d F Y') }}</td>
                    <th class="text-left leading-none py-2 m-0">Jam</th>
                    <td class="leading-none py-2 m-0">: </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>