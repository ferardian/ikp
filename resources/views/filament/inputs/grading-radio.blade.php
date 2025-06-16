@php
    $gridDirection = $getGridDirection() ?? 'column';
    $id = $getId();
    $isDisabled = $isDisabled();
    $isInline = $isInline();
    $statePath = $getStatePath();

    $bgColors = [
        'Merah' => 'bg-rose-500 hover:bg-rose-600 ease-in-out duration-300 transition-colors ',
        'Kuning' => 'bg-amber-500 hover:bg-amber-600 ease-in-out duration-300 transition-colors ',
        'Hijau' => 'bg-emerald-500 hover:bg-emerald-600 ease-in-out duration-300 transition-colors ',
        'Biru' => 'bg-sky-500 hover:bg-sky-600 ease-in-out duration-300 transition-colors ',
    ];

    $radioColor = [
        'Merah' => 'hover:checked:bg-rose-900 checked:bg-rose-800',
        'Kuning' => 'hover:checked:bg-amber-900 checked:bg-amber-800',
        'Hijau' => 'hover:checked:bg-emerald-900 checked:bg-emerald-800',
        'Biru' => 'hover:checked:bg-sky-900 checked:bg-sky-800',
    ];

    $insidenUnitSama = $insidenPadaUnitYangSama ?? \App\Filament\Resources\InsidenResource::getInsidenPadaUnitYangSama()
@endphp

<div>
    <x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
        <x-filament::grid
            :default="$getColumns('default')"
            :sm="$getColumns('sm')"
            :md="$getColumns('md')"
            :lg="$getColumns('lg')"
            :xl="$getColumns('xl')"
            :two-xl="$getColumns('2xl')"
            :is-grid="! $isInline"
            :direction="$gridDirection"
            :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'fi-fo-radio gap-4',
                    '-mt-4' => (! $isInline) && ($gridDirection === 'column'),
                    'flex flex-wrap' => $isInline,
                ])
        "
        >
            @foreach ($getOptions() as $value => $label)
                <div
                    @class([
                        'break-inside-avoid pt-4' => (! $isInline) && ($gridDirection === 'column'),
                    ])
                >
                    <label class="flex gap-x-3 w-full rounded-lg px-4 py-1 {{ $bgColors[$value] }}">
                        <x-filament::input.radio
                            :valid="! $errors->has($statePath)"
                            :attributes="
                            \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                                ->merge([
                                    'disabled' => $isDisabled || $isOptionDisabled($value, $label),
                                    'id' => $id . '-' . $value,
                                    'name' => $id,
                                    'value' => $value,
                                    'wire:loading.attr' => 'disabled',
                                    $applyStateBindingModifiers('wire:model') => $statePath,
                                ], escape: false)
                                ->class(['mt-1', $radioColor[$value]])
                        "
                        />

                        <div class="grid text-sm leading-6">
                        <span class="font-medium text-gray-950 dark:text-white">
                            {{ $label }}
                        </span>

                            @if ($hasDescription($value))
                                <p class="text-gray-500 dark:text-gray-400">
                                    {{ $getDescription($value) }}
                                </p>
                            @endif
                        </div>
                    </label>
                </div>
            @endforeach
        </x-filament::grid>
    </x-dynamic-component>



    <div class="mt-8">
        <x-filament::section collapsible>
            <x-slot name="heading">
                Data Insiden Pada Unit Kerja Yang Sama
            </x-slot>

            <x-slot name="description">
                Data dibawah ini diambil 5 data terbaru yang pernah terjadi pada unit kerja yang sama.
            </x-slot>

            <table class="table table-auto w-full">
                <thead class="dark:bg-gray-700 bg-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">No.</th>
                        <th class="px-4 py-2 text-left font-semibold">Insiden</th>
                        <th class="px-4 py-2 text-left font-semibold">Jenis</th>
                        <th class="px-4 py-2 text-left font-semibold">Tanggal Kejadian</th>
                        <th class="px-4 py-2 text-left font-semibold">Dampak</th>
                        <th class="px-4 py-2 text-left font-semibold">Tempat Kejadian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insidenUnitSama as $item)
                        <tr class="border-b border-b-gray-200 dark:border-b-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $item->insiden }}</td>
                            <td class="px-4 py-2">{{ $item->jenis?->alias }}</td>
                            <td class="px-4 py-2">{{ $item->tanggal_insiden?->translatedFormat('l, d F Y') }}</td>
                            <td class="px-4 py-2">{{ \Str::upper($item->dampak_insiden) }}</td>
                            <td class="px-4 py-2">
                                <p>{{ $item->tempat_kejadian }}</p>
                                <p class="text-sm text-gray-500">Unit : {{ $item->unit?->nama_unit }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::section>
    </div>
</div>
