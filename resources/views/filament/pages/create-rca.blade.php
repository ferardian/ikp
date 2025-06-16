<x-filament::page>
    <x-filament::card>
        <div class="mb-3 space-y-1">
            <h2 class="text-md font-semibold">Insiden</h2>
            <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->insiden }}</p>
        </div>

        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            <div class="mb-3 space-y-1">
                <h2 class="text-md font-semibold">Waktu Kejadian</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">
                    {{ $insiden ? \Carbon\Carbon::parse($insiden->tanggal_insiden->format('Y-m-d') . ' ' . $insiden->waktu_insiden)->translatedFormat('l, d F Y H:i') : '' }}
                </p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-md font-semibold">Tempat</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->tempat_kejadian }}</p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-md font-semibold">Unit</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->unit?->nama_unit }}</p>
            </div>

            <div class="mb-3 space-y-1">
                <h2 class="text-md font-semibold">Dampak</h2>
                <p class="dark:text-gray-400 text-gray-500 capitalize">{{ $insiden?->dampak_insiden }}</p>
            </div>
        </div>
    </x-filament::card>

    <form wire:submit.prevent="create">
        {{ $this->form }}
    </form>
</x-filament::page>
