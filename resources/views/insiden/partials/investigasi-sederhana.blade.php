@if ($insiden->investigasi_sederhana)
    <div class="page-break"></div>
    
    {{-- Investigasi Sederhana --}}
    <div class="mb-8">
        <div class="mb-4">
            <h1 class="text-xl font-bold text-center">INVESTIGASI SEDERHANA</h1>
        </div>

        <div class="ml-8 mt-1">
            <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                <tbody>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Manager / Kepala Bagian / Kepala Unit</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->investigasi_sederhana?->kepala?->name }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Penyebab Insiden Langsung</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>{{ $insiden->investigasi_sederhana?->penyebab_insiden }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Penyebab yang Melatarbelakangi Insiden</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>{{ $insiden->investigasi_sederhana?->penyebab_melatarbelakangi }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="align-top border-b">
                        <td colspan="4" style="background-color: #fff;">
                            <div class="text-center mt-4">REKOMENDASI</div>
                        </td>
                    </tr>

                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Rekomendasi</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>{!! $insiden->investigasi_sederhana?->rekomendasi !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Direkomendasikan Oleh</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->investigasi_sederhana?->pj_rekomendasi?->name }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Rekomendasi Diberikan</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->investigasi_sederhana?->tanggal_rekomendasi?->translatedFormat('d F Y') }}</td>
                    </tr>

                    <tr class="align-top border-b">
                        <td colspan="4" style="background-color: #fff;">
                            <div class="text-center mt-4">TINDAKAN</div>
                        </td>
                    </tr>

                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tindakan</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>{!! $insiden->investigasi_sederhana?->tindakan_rekomendasi !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Ditindak Oleh</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->investigasi_sederhana?->pj_tindakan?->name }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Tindak Lanjut</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->investigasi_sederhana?->tanggal_tindakan?->translatedFormat('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
@endif