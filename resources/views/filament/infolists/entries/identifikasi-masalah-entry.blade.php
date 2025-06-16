@php
    $sortedItems = collect($getState())->sortBy('type');
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($sortedItems as $index => $item)
            <x-filament::section
                collapsible
                :collapsed="!in_array($item['type'], ['fishbone'])"
                class="{{in_array($item['type'], ['fishbone']) ? 'col-span-2' : ''}}">
                <x-slot name="heading">
                    <p class="text-sm font-semibold">
                        {{ $item['type'] }} Analysis {{ $loop->iteration }}
                    </p>
                </x-slot>

                @if($item['type'] == '5why')
                    <x-filament.infolist.entries.repeater-5-why :data="$item['data']" />
                @elseif($item['type'] == 'fishbone')
                    @php
                        $data = $item['data'];
                        // $mappedData = (new \App\Http\Controllers\RCAFishboneController())->mapFishboneData($data);
                    @endphp

                    <x-filament.infolist.entries.fishbone :key="$index" :id="1" />
                    {{-- <x-filament.infolist.entries.fishbone :data="$mappedData" :id="\Str::slug($data['masalah'])" /> --}}
                @endif

                {{-- Content --}}
            </x-filament::section>
        @endforeach
    </div>
</x-dynamic-component>
