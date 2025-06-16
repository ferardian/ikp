@props([
    'data', 'title', 'imagesData'
])

<div class="page-break"></div>

<div class="ml-8 mb-3">
    <p class="mb-2">Analisis {{ \Str::title(\Str::replace('-', ' ', $title)) }}</p>
    
    @foreach ($data as $key => $item)
        <img src="data:image/png;base64,{{ $imagesData[$key] }}" alt="{{ $key }}" class="w-full">
    @endforeach
</div>