<div>
    @if($riskGrading)
        <div class="alert flex flex-row items-start px-5 py-2 gap-4 rounded-lg {{ $classes['alertClasses'] ?? 'bg-gray-100 dark:bg-gray-800 border-gray-300' }}">
            <div class="alert-icon flex items-center border {{ $classes['iconClasses'] ?? 'bg-gray-50 border-gray-500 text-gray-500' }} justify-center h-10 w-10 flex-shrink-0 rounded-full mt-2">
                <span class="{{ explode(' ', ($classes['iconClasses'] ?? "bg-gray-50 border-gray-500 text-gray-500"))[1] }}">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            <div class="alert-content w-full">
                <div class="alert-title font-semibold text-lg {{ $classes['titleClasses'] ?? 'text-gray-800 dark:text-gray-200' }}">
                    Auto Grading Sistem
                </div>
                <div class="alert-description text-sm {{ $classes['bodyClasses'] ?? 'text-gray-600 dark:text-gray-300' }}">
                    <p class="text-sm font-normal">
                        Berdasarkan data yang telah diinput (jenis insiden, unit, dan dampak insiden). <br />
                        Sistem memberikan grading insiden ini sebagai
                        <span class="font-bold underline capitalize grading-text">{{ $autoColor }}</span>.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="alert flex flex-row items-start px-5 py-2 gap-4 rounded-lg bg-gray-100 dark:bg-gray-800 border-gray-300">
            <div class="alert-icon flex items-center border bg-gray-50 border-gray-500 text-gray-500 justify-center h-10 w-10 flex-shrink-0 rounded-full mt-2">
                <span class="bg-gray-50 border-gray-500 text-gray-500">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            <div class="alert-content w-full">
                <div class="alert-title font-semibold text-lg text-gray-800 dark:text-gray-200">
                    Auto Grading Sistem
                </div>
                <div class="alert-description text-sm text-gray-600 dark:text-gray-300">
                    <p class="text-sm font-normal">
                        Anda sepertinya <b>belum mengisi data insiden dengan benar</b>, <u>Auto Grading</u> sistem belum dapat memberikan grading insiden ini. <br />
                        Silahkan periksa kembali data insiden Anda.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
