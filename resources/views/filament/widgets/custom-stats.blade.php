@php
    $colors = [
        'Biru'   => 'bg-sky-300 dark:bg-sky-600',
        'Hijau'  => 'bg-emerald-300 dark:bg-emerald-600',
        'Kuning' => 'bg-amber-300 dark:bg-amber-600',
        'Merah'  => 'bg-rose-300 dark:bg-rose-600',
    ];

    $countColor = [
        'Biru'   => 'bg-sky-100 dark:bg-sky-200 text-sky-700 border-2 border-white',
        'Hijau'  => 'bg-emerald-100 dark:bg-emerald-200 text-emerald-700 border-2 border-white',
        'Kuning' => 'bg-amber-100 dark:bg-amber-200 text-amber-700 border-2 border-white',
        'Merah'  => 'bg-rose-100 dark:bg-rose-200 text-rose-700 border-2 border-white',
    ];

    $titleColor = [
        'Biru'   => 'text-sky-900 dark:text-sky-100',
        'Hijau'  => 'text-emerald-900 dark:text-emerald-100',
        'Kuning' => 'text-amber-900 dark:text-amber-100',
        'Merah'  => 'text-rose-900 dark:text-rose-100',
    ];

    $subtitleColor = [
        'Biru'   => 'text-sky-800 dark:text-sky-200',
        'Hijau'  => 'text-emerald-800 dark:text-emerald-200',
        'Kuning' => 'text-amber-800 dark:text-amber-200',
        'Merah'  => 'text-rose-800 dark:text-rose-200',
    ];
@endphp

<div class="{{ $colors[$label] ?? 'bg-gray-300' }} overflow-hidden sm:rounded-2xl grading-item">
    <div class="p-6 text-gray-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="{{ $titleColor[$label] ?? 'text-gray-800' }} font-semibold capitalize">{{ $label }}</p>
                <p class="{{ $subtitleColor[$label] ?? 'text-gray-800' }} text-xs font-medium">Insiden dengan grading {{ $label }}</p>
            </div>

            <div class="flex items-center justify-center w-12 h-12 rounded-full {{ $countColor[$label] ?? 'bg-gray-100 text-gray-600 border-2 border-white' }}">
                <p class="text-2xl font-semibold">{{ $value }}</p>
            </div>
        </div>
    </div>
</div>
