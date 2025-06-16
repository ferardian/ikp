<x-filament-widgets::widget class="fi-wi-stats-overview">
    <div
        @if ($pollingInterval = $this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}
        @endif
        @class([
            'fi-wi-stats-overview-stats-ctn grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5',
        ])
    >
        @foreach ($this->getCachedStats() as $index => $stat)
            <div class="{{ $loop->last ? 'col-span-1 sm:col-span-2 md:col-span-2 xl:col-span-4 2xl:col-span-1' : '' }}">
                {{ $stat }}
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
