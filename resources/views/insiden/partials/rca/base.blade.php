@if ($insiden->rca)
    <div class="page-break"></div>
    
    {{-- RCA --}}
    <div class="mb-8">
        <div class="mb-4">
            <h1 class="text-xl font-bold text-center">ROOT CAUSE ANALYSIS (RCA)</h1>
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">I.</p></td>
                    <td><p class="text-base">TIM INVESTIGASI</p></td>
                </tr>
            </table>

            <div class="ml-8 mt-1">
                <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                    <tr class="align-top">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Ketua</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->rca?->ketua->name }}</td>
                    </tr>
                    <tr class="align-top">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Anggota</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            @php
                                $anggotas = \App\Models\User::whereIn('id', $insiden->rca?->members)->get();
                            @endphp

                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td style="width: 100%;">
                                        <div class="ml-5">
                                            <ol class="list-decimal">
                                                @foreach ($anggotas as $anggota)
                                                    <li>
                                                        <p class="leading-5">{{ $anggota->name }}</p>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">II.</p></td>
                    <td><p class="text-base">DATA DAN INFORMASI</p></td>
                </tr>
            </table>
            
            @if ($insiden->rca?->data_primer)
                <div class="ml-8 mb-3">
                    <p class="mb-2">Data Primer</p>
                    <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                        <thead>
                            <tr class="border">
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Sumber Data / Informasi</th>
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Catatan Penting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insiden->rca?->data_primer as $item)
                            <tr class="border">
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['data'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['catatan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($insiden->rca?->data_sekunder)
                <div class="ml-8 mb-3">
                    <p class="mb-2">Data Sekunder</p>
                    <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                        <thead>
                            <tr class="border">
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Sumber Data / Informasi</th>
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Catatan Penting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insiden->rca?->data_sekunder as $item)
                            <tr class="border">
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['data'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['catatan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            
            @if ($insiden->rca?->data_lainnya)
                <div class="ml-8 mb-3">
                    <p class="mb-2">Data Lainnya</p>
                    <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                        <thead>
                            <tr class="border">
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Sumber Data / Informasi</th>
                                <th class="text-left border leading-none px-2 py-2 m-0" style="width:50%; background-color: #d1d1d1;">Catatan Penting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insiden->rca?->data_lainnya as $item)
                            <tr class="border">
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['data'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['catatan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">III.</p></td>
                    <td><p class="text-base">PETA KRONOLOGI KEJADIAN</p></td>
                </tr>
            </table>
            
            <div class="ml-8 mb-3">
                <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                    <thead>
                        <tr class="border">
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Kejadian</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Informasi Tambahan</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Good Practice</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Masalah Pelayanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insiden->rca?->kronologi_waktu_kejadian as $item)
                        <tr>
                            <td class="border leading-none px-2 py-2 m-0 text-center font-bold text-sm" style="background-color: #e4e4e4" colspan="4">
                                {{ \Carbon\Carbon::parse($item['waktu-kejadian'])->translatedFormat('l, d F Y H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['kejadian'] }}</td>
                            <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['informasi-tambahan'] }}</td>
                            <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['good-practice'] }}</td>
                            <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['masalah-pelayanan'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">IV.</p></td>
                    <td><p class="text-base">ANALISIS PENYEBAB MASALAH</p></td>
                </tr>
            </table>

            @php
                $identifikasi_masalah = collect($insiden->rca->identifikasi_masalah)->groupBy('type')->map(function ($item) {
                    return $item->map(function ($item) {
                        return $item['data'];
                    });
                });
            @endphp

            @foreach ($identifikasi_masalah as $key => $item)
                @if (in_array($key, ['5why', '5-why']))
                    <x-insiden.rca.5-why :data="$item" :title="$key"/>
                @endif

                @if (in_array($key, ['fishbone']))
                    <x-insiden.rca.fishbone :data="$item" :title="$key" :imagesData="$fishboneImageData" />
                @endif
            @endforeach
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">V.</p></td>
                    <td><p class="text-base">PERUBAHAN DAN PENGHALANG</p></td>
                </tr>
            </table>

            @php
                $perubahan_dan_penghalang = collect($insiden->rca->perubahan_dan_penghalang)->groupBy('type')->map(function ($item) {
                    return $item->map(function ($item) {
                        return $item['data'];
                    });
                });
            @endphp

            @foreach ($perubahan_dan_penghalang as $key => $item)
            <div class="ml-8 mb-3">
                <p class="mb-2">{{ \Str::title(\Str::replace('_', ' ', $key)) }}</p>

                <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                    <thead>
                        <tr class="border">
                            <th class="text-center border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">No.</th>
                            @foreach ($item[0] as $subkey => $subitem)
                                <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">
                                    {{ \Str::title(\Str::replace('-', ' ', $subkey)) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item as $subitem)
                            <tr>
                                <td class="text-center border leading-none px-2 py-2 m-0">{{ $loop->iteration }}</td>
                                @foreach ($subitem as $subsubitem)
                                    <td class="text-left border leading-none px-2 py-2 m-0">{{ $subsubitem }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            @endforeach
        </div>

        <div class="mb-8">
            <table class="table w-full">
                <tr>
                    <td style="width: 30px;"><p class="text-base">VI.</p></td>
                    <td><p class="text-base">REKOMENDASI DAN RENCANA TINDAKAN</p></td>
                </tr>
            </table>
            
            <div class="ml-8 mb-3">
                <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                    <thead>
                        <tr class="border">
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Akar Masalah</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Rekomendasi</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">TK. Rekomendasi</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Sumber Daya</th>
                            <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insiden?->rca?->rekomendasi as $item)
                            <tr>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['akar_masalah'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['rekomendasi'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['tim'] }}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{!! $item['sumber_daya'] !!}</td>
                                <td class="text-left border leading-none px-2 py-2 m-0">{{ $item['bukti'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left border leading-none px-2 py-2 m-0">
                                    <p class="mb-1"><b>Tanggal</b></p>
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('l, d F Y') }}
                                </td>
                                {{-- <td colspan="2" class="text-left border leading-none px-2 py-2 m-0">
                                    <p class="mb-1"><b>Penanggung Jawab</b></p>
                                    @php
                                        $pj = \App\Models\User::find($item['penanggung_jawab']);
                                    @endphp

                                    {{ $pj->name }}
                                </td> --}}
                                <td colspan="1" class="text-left border leading-none px-2 py-2 m-0">
                                    @php
                                        $pj = \App\Models\User::find($item['penanggung_jawab']);
                                    @endphp
                                    
                                    <img src="{{ $item['signature'] }}"/>
                                    <div class="border mb-2"></div>
                                    <p class="text-center">{{ $pj->name }}</p>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td colspan="5" class="border leading-none px-2 py-2 m-0">
                                    <img src="{{ $item['signature'] }}"/>
                                </td>
                            </tr> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif