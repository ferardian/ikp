<x-filament::page>
    <x-filament::card>
        <div class="mb-3 space-y-1">
            <h2 class="text-base font-semibold">Insiden</h2>
            <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->insiden }}</p>
        </div>

        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            <div class="mb-3 space-y-1">
                <h2 class="text-base font-semibold">Waktu Kejadian</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">
                    {{ $insiden ? \Carbon\Carbon::parse($insiden->tanggal_insiden->format('Y-m-d') . ' ' . $insiden->waktu_insiden)->translatedFormat('l, d F Y H:i') : '' }}
                </p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-base font-semibold">Tempat</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->tempat_kejadian }}</p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-base font-semibold">Unit</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->unit?->nama_unit }}</p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-base font-semibold">Dampak</h2>
                <div class="w-fit">
                    <x-filament::badge :color="match($insiden?->dampak_insiden) {
                        'tidak signifikan' => 'success',
                        'minor' => 'primary',
                        'moderat' => 'warning',
                        'mayor' => 'danger',
                        'katastropik' => 'danger',
                        default => 'gray',
                    }">
                        {{ \Str::upper($insiden?->dampak_insiden) }}
                    </x-filament::badge>
                </div>
            </div>
        </div>
    </x-filament::card>

    <form wire:submit.prevent="save">
        {{ $this->form }}
    </form>
</x-filament::page>
