@php
    $collectState = collect($getState());

    $type_perubahan = $collectState->where('type', 'analisis_perubahan')->values()->all();
    $type_penghalang = $collectState->where('type', 'analisis_penghalang')->values()->all();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <div class="mb-8">
            <div class="font-bold text-md mb-3">
                Analisis Perubahan
            </div>

            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 tracking-wide">Prosedur Sesuai SOP</th>
                        <th scope="col" class="px-6 py-3 tracking-wide">Prosedur Yang Dilakukan Saat Insiden</th>
                        <th scope="col" class="px-6 py-3 tracking-wide">Apakah Terdapat Bukti Perubahan Dalam Proses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($type_perubahan as $index => $item)
                        <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-800">
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['prosedur-sesuai-sop'] ?? "-"}}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['prosedur-saat-insiden'] ?? "-"}}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['bukti-perubahan-dalam-proses'] ?? "-"}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <div class="font-bold text-md mb-3">
                Analisis Penghalang
            </div>

            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 tracking-wide">Apa Penghalang Pada Masalah Ini ?</th>
                    <th scope="col" class="px-6 py-3 tracking-wide">Apakah Penghalang Dilakukan ?</th>
                    <th scope="col" class="px-6 py-3 tracking-wide">Mengapa Penghalang Gagal ? Apa Dampaknya ?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($type_penghalang as $index => $item)
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-800">
                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['penghalang'] ?? "-"}}</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['penghalang-dilakukan'] ?? "-"}}</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{$item['data']['mengapa-gagal'] ?? "-"}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dynamic-component>
