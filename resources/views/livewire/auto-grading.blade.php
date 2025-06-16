@php
    $alertClasses = [
        'Rendah'  => 'bg-sky-100 dark:bg-sky-800 border-sky-300',
        'Moderat' => 'bg-emerald-100 dark:bg-emerald-800 border-emerald-300',
        'Tinggi'  => 'bg-amber-100 dark:bg-amber-800 border-amber-300',
        'Ekstrim' => 'bg-rose-100 dark:bg-rose-800 border-rose-300',
    ];
    
    $iconClasses = [
        'Rendah'  => 'bg-sky-50 border-sky-500 text-sky-500',
        'Moderat' => 'bg-emerald-50 border-emerald-500 text-emerald-500',
        'Tinggi'  => 'bg-amber-50 border-amber-500 text-amber-500',
        'Ekstrim' => 'bg-rose-50 border-rose-500 text-rose-500',
    ];

    $titleClasses = [
        'Rendah'  => 'text-sky-800 dark:text-sky-200',
        'Moderat' => 'text-emerald-800 dark:text-emerald-200',
        'Tinggi'  => 'text-amber-800 dark:text-amber-200',
        'Ekstrim' => 'text-rose-800 dark:text-rose-200',
    ];

    $bodyClasses = [
        'Rendah'  => 'text-sky-600 dark:text-sky-300',
        'Moderat' => 'text-emerald-600 dark:text-emerald-300',
        'Tinggi'  => 'text-amber-600 dark:text-amber-300',
        'Ekstrim' => 'text-rose-600 dark:text-rose-300',
    ];

    $alertClass = $alertClasses[$riskGrading] ?? $alertClasses['Rendah'];
    $iconColor = $iconClasses[$riskGrading] ?? $iconClasses['Rendah'];
    $titleColor = $titleClasses[$riskGrading] ?? $titleClasses['Rendah'];
    $bodyColor = $bodyClasses[$riskGrading] ?? $bodyClasses['Rendah'];
@endphp

<div class="alert flex flex-row items-start px-5 py-2 gap-4 rounded-lg {{ $alertClass }}">
    <div class="alert-icon flex items-center border {{ $iconColor }} justify-center h-10 w-10 flex-shrink-0 rounded-full mt-2">
        <span class="{{ explode(' ', $iconColor)[1] }}">
            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </div>
    <div class="alert-content w-full">
        <div class="alert-title font-semibold text-lg {{ $titleColor }}">
            Auto Grading Sistem
        </div>
        <div class="alert-description text-sm {{ $bodyColor }}">
            <p class="text-sm font-normal">
                Berdasarkan data yang telah diinput (jenis insiden, unit, dan dampak insiden). <br />
                Sistem memberikan grading insiden ini sebagai 
                <span class="font-bold underline capitalize grading-text">{{ $autoColor }}</span>.
            </p>
        </div>

        <input type="hidden" name="auto_grading" value="{{ $autoColor }}">
    </div>
</div>