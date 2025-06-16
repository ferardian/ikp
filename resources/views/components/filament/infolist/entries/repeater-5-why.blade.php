@props([
    'data' => [],
])

<div>
    <div class="mb-3">
        <p class="text-gray-700 dark:text-gray-400 text-sm">Masalah</p>
        <p class="font-semibold text-base">
            {{ $data['masalah'] }}
        </p>
    </div>

    <ul class="list list-decimal pl-5">
        @foreach($data['repeater-whys'] as $index => $item)
            <li>{{$item['whys']}}</li>
        @endforeach
    </ul>
</div>
