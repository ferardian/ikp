<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}').live,
        isOpen: false,
        currentDecade: Math.floor({{ $getMaxYear() ?? now()->year }} / 10) * 10,
        maxYear: {{ $getMaxYear() ?? now()->year }},
        minDecade: {{ $getMinYear() ?? 1900 }},
        get startYear() {
            return this.currentDecade;
        },
        get endYear() {
            return Math.min(this.currentDecade + 11, this.maxYear);
        },
        get years() {
            return Array.from({ length: 12 }, (_, i) => this.startYear + i).filter(y => y <= this.maxYear);
        },
        selectYear(year) {
            if (year <= this.maxYear) {
                this.state = year;
                this.isOpen = false;
            }
        },
        changeDecade(delta) {
            let newDecade = this.currentDecade + delta;
            if (newDecade + 11 >= this.maxYear) {
                newDecade = Math.max(this.maxYear - 11, this.minDecade);
            } else if (newDecade < this.minDecade) {
                newDecade = this.minDecade;
            }
            this.currentDecade = newDecade;
        }
    }" class="relative">

        <!-- Input Box -->
        <x-filament::input.wrapper>
            <x-filament::input type="text" x-model="state" :placeholder="$getPlaceholder()" readonly="true" @click="isOpen = !isOpen" />
        </x-filament::input.wrapper>

        <!-- Dropdown Tahun -->
        <x-filament::section
            x-show="isOpen" @click.outside="isOpen = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute top-full left-0 border border-gray-300 rounded shadow-lg z-10 mt-1 w-full bg-white p-2">

            <!-- Navigasi Dekade -->
            <div class="flex justify-between items-center mb-2 px-2">
                <x-filament::icon-button icon="heroicon-m-chevron-left" @click="changeDecade(-10)" color="gray" />
                <span x-text="startYear + ' - ' + endYear" class="font-semibold"></span>
                <x-filament::icon-button icon="heroicon-m-chevron-right" @click="changeDecade(10)" color="gray" />
            </div>

            <!-- Grid Tahun -->
            <div x-bind:class="'grid grid-cols-2 gap-2'">
                <template x-for="year in years" :key="year" style="display: grid; grid-column: 2">
                    <x-filament::button x-bind:class="{ 'bg-gray-400/10': year === state }" @click="selectYear(year)" class="text-center" color="gray" outlined x-text="year"></x-filament::button>
                </template>
            </div>
        </x-filament::section>
    </div>
</x-dynamic-component>
