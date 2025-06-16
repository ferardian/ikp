@props([
    'data', 'title'
])

<div class="ml-8 mb-3">
    <p class="mb-2">Analisis {{ \Str::title(\Str::replace('-', ' ', $title)) }}</p>
    
    @foreach ($data as $item)
        <table class="table w-full mb-3" style="font-size: 12pt; font-weight: normal;">
            <thead>
                <tr class="border">
                    <th class="text-center border leading-none px-2 py-2 m-0" style="width: 100px; background-color: #d1d1d1;">Masalah : </th>
                    <th class="text-left border leading-none px-2 py-2 m-0" style="background-color: #d1d1d1;">{{ $item['masalah'] }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item['repeater-whys'] as $subsubitem)
                    <tr>
                        <td class="text-center border leading-none px-2 py-2 m-0">Mengapa ?</td>
                        <td class="text-left border leading-none px-2 py-2 m-0">{{ $subsubitem['whys'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>