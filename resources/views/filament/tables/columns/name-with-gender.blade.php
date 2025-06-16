<div class="flex lg:items-center gap-2 w-full mx-3">
    <div>
        @if ($getRecord()->jenis_kelamin == 'L')
            <x-icons.gender-male class="h-5 w-5 text-blue-600" />
        @else
            <x-icons.gender-female class="h-5 w-5 text-pink-600" />
        @endif
    </div>
    <div class="max-w-sm lg:w-full truncate text-ellipsis whitespace-nowrap">
        {{ $getRecord()->nama }}
    </div>    
</div>