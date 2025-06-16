{{-- Tindakan Section --}}
<div class="mb-8">
    <table class="table w-full">
        <tr>
            <td style="width: 30px;"><p class="text-lg">III.</p></td>
            <td><p class="text-lg">TINDAKAN PASCA INSIDEN</p></td>
        </tr>
    </table>

    <div class="ml-8 mt-1">
        <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
            <tbody>
                <tr class="align-top border-b">
                    
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tindakan</th>
                    <td class="leading-none py-2 m-0" colspan="3">
                        <table class="w-fit">
                            <tr class="align-top">
                                <td style="width: 7px;">:</td>
                                <td>{!! $insiden->tindakan?->content !!}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tindakan Oleh</th>
                    <td class="leading-none py-2 m-0" colspan="3">: {{ in_array($insiden->tindakan?->oleh, ['tim', 'petugas']) ? \Str::ucfirst($insiden->tindakan?->oleh) . " : " . $insiden->tindakan?->detail : $insiden->tindakan?->oleh }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tindakan Diisi Pada</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->tindakan?->created_at?->translatedFormat('d F Y') }}</td>
                    <th class="text-left leading-none py-2 m-0" style="width: 10px;">Jam</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->tindakan?->created_at?->format('H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>