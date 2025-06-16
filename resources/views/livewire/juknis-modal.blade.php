<div>
    <x-filament::modal id="edit-user" width="4xl" slide-over>
        <!-- Render PDF File in here from public/storage/juknis/juknis.pdf -->
        <iframe src="{{ $juknisUrl }}" class="w-full h-full"></iframe>
    </x-filament::modal>
</div>
