{{-- Grading Section --}}
<div class="mb-8">
    <table class="table w-full">
        <tr>
            <td style="width: 30px;"><p class="text-lg">IV.</p></td>
            <td><p class="text-lg">GRADING INSIDEN</p></td>
        </tr>
    </table>

    <div class="ml-8 mt-1">
        <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
            <tbody>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Grading</th>
                    <td class="leading-none py-2 m-0" colspan="3">:
                        @php
                            $badgeColor = match ($insiden->grading?->grading_risiko) {
                                'Biru' => 'bg-blue-500 text-white',
                                'Hijau' => 'bg-green-500 text-white',
                                'Kuning' => 'bg-yellow-500 text-white',
                                'Merah' => 'bg-red-500 text-white',
                                default => 'bg-gray-500 text-white',
                            };
                        @endphp
                        
                        <span class="pl-1 pr-2 pl-4 py-1 rounded {{ $badgeColor }} w-fit">{{ $insiden->grading?->grading_risiko }}</span>
                    </td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Grading Oleh</th>
                    <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->grading?->oleh?->name }}</td>
                </tr>
                <tr class="align-top border-b">
                    <th class="text-left leading-none py-2 m-0" style="width: 150px;">Grading Pada</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->grading?->created_at?->translatedFormat('d F Y') }}</td>
                    <th class="text-left leading-none py-2 m-0" style="width: 10px;">Jam</th>
                    <td class="leading-none py-2 m-0">: {{ $insiden->grading?->created_at?->format('H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>