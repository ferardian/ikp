<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>PDF Print - Laporan Insiden</title>
    
    <link rel="stylesheet" href="{{ public_path('/build/assets/pdf.css') }}" media="all" text="text/css">
    {{-- <link rel="stylesheet" href="{{ Vite::asset('resources/css/pdf.css') }}"> --}}

    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 0; padding: 0; } @page { margin: 1cm; } .dejavu { font-family: 'DejaVu Sans', sans-serif } .page-break { page-break-after: always }
    </style>
</head>

<body>
    <div class="mb-4">
        <h1 class="text-xl font-bold text-center">LAPORAN INSIDEN</h1>
        <h1 class="text-base text-center">(INTERNAL)</h1>
    </div>

    <div class="w-full border-2 rounded-lg p-1 text-center mb-4 bg-yellow-50 border-yellow-100">
        <p class="text-center">RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAKSIMAL 2 x 24 JAM</p>
    </div>

    <div class="main font-medium">
        @include('insiden.partials.pasien')
        @include('insiden.partials.insiden')
        @include('insiden.partials.tindakan')
        @include('insiden.partials.grading')
        @include('insiden.partials.investigasi-sederhana')
        @include('insiden.partials.rca.base')
                
        {{-- <div class="ml-8 mt-1">
            <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                <tr>
                    <td class="w-full">
                        <p class="font-bold">Pembuat Laporan</p>
                        <p class="text-xs">{{ $insiden->created_at?->translatedFormat('l, d F Y') }}</p>

                        @if ($insiden->created_sign)
                            <img class="h-[100px]" src="{{ asset('storage/'.$insiden->created_sign) }}">
                        @else
                            <div style="padding-top: 50px; padding-bottom: 50px;"></div>
                        @endif

                        <p class="font-bold text-sm">{{ $insiden->oleh->name }}</p>
                    </td>
                    <td class="w-full">
                        <p class="font-bold">Penerima Laporan</p>
                        <p class="text-xs">{{ $insiden->received_at?->translatedFormat('d F Y') ?? '-'}}</p>

                        @if ($insiden->received_sign)
                            <img class="h-[100px]" src="{{ asset('storage/'.$insiden->received_sign) }}">
                        @else
                            <div style="padding-top: 50px; padding-bottom: 50px;"></div>
                        @endif

                        <p class="font-bold">{{ $insiden->penerima->name ?? '-' }}</p>
                    </td>
                </tr>
            </table>
        </div> --}}
    </div>
</body>

</html>
