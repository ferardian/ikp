<x-filament::page>
    <livewire:auto-grading :insiden="$this->record" />

    <form wire:submit.prevent="confirmSave">
        {{ $this->form }}
        
        <x-filament::button type="submit" class="mt-4">
            Simpan Perubahan
        </x-filament::button>
    </form>


    <x-filament::modal id="confirm-save" width="2xl">
        <x-slot name="header">
            <h2 class="text-lg font-bold">Peringatan !</h2>
        </x-slot>

        <p>Grading risiko insiden yang anda pilih berbeda dengan auto grading, apakah anda yakin ingin menyimpan perubahan ini ?</p>

        <x-slot name="footer">
            <x-filament::button color="gray" wire:click="$dispatch('close-modal', {id: 'confirm-save'})">
                Batal
            </x-filament::button>

            <x-filament::button color="primary" wire:click="save">
                Ya, Simpan
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament::page>