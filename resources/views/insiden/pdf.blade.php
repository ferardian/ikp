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
        @page {
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.45;
            font-size: 9.5pt;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4 {
            color: #0f172a;
            margin: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .dejavu {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #2563eb;
            vertical-align: middle;
        }
        
        /* Banner Rahasia */
        .confidential-banner {
            background-color: #fef2f2;
            border: 1px dashed #fee2e2;
            color: #ef4444;
            padding: 8px 12px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
            border-radius: 6px;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        /* Section styling */
        .section-container {
            margin-bottom: 25px;
        }
        .section-header-large {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .section-header {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 12px;
        }
        .section-number {
            color: #3b82f6;
            margin-right: 6px;
        }

        /* Info table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td, .info-table th {
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-table tr {
            border-bottom: 1px solid #f1f5f9;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .label-cell {
            font-weight: bold;
            color: #475569;
            text-align: left;
            font-size: 9.5pt;
        }
        .colon-cell {
            width: 12px;
            text-align: center;
            color: #94a3b8;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .value-cell {
            color: #0f172a;
        }

        /* Nested tables for checkboxes */
        .nested-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .nested-table td {
            padding: 2px 0 !important;
            border: none !important;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div style="text-align: center; margin-bottom: 20px; border-bottom: 3px double #1e3a8a; padding-bottom: 5px;">
        <img src="{{ public_path('images/header.png') }}" style="width: 100%; height: auto; display: block;">
    </div>

    <div style="margin-bottom: 20px;">
        <h1 class="section-header-large" style="margin-bottom: 4px;">LAPORAN INSIDEN KESELAMATAN PASIEN</h1>
        <h2 style="font-size: 12pt; text-align: center; color: #475569; font-weight: normal;">(INTERNAL REPORT)</h2>
    </div>

    <div class="confidential-banner">
        RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAKSIMAL 2 x 24 JAM
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
