<?php

namespace App\Http\Controllers;

use App\Models\Insiden;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function print(Insiden $insiden)
    {
        $insiden = $insiden->load([
            'rca',
            'oleh',
            'jenis',
            'unit',
            'tindakan',
            'grading.oleh',
            'investigasi_sederhana.kepala',
            'investigasi_sederhana.pj_rekomendasi',
            'investigasi_sederhana.pj_tindakan',
            'pasien.penanggungBiaya',
        ]);

        $base64Data = [];
        if ($insiden->rca) {
            $fishboneController = new RCAFishboneController();
            $fishbone = $fishboneController->getFishboneData($insiden->rca);

            foreach($fishbone as $key => $item) {
                $base64Data[] = \Spatie\Browsershot\Browsershot::url(route('rca.fishbone.render', ['key' => $key, 'id' => $insiden->rca->id]))
                    ->waitUntilNetworkIdle()
                    ->windowSize(1152, 648)
                    ->base64Screenshot();
            }
            
        }

        // $fishboneBase64 = $this->getFishboneImage($insiden);

        // return view('insiden.pdf', [
        //     'insiden'     => $insiden,
        //     'probability' => $probability ?? null,
        //     'impact'      => $impact ?? null,
        //     'riskGrading' => $riskGrading ?? null,
        //     'terkait'     => $terkait ?? null,
        // ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('insiden.pdf', [
            'insiden'           => $insiden,
            'probability'       => $probability ?? null,
            'impact'            => $impact ?? null,
            'riskGrading'       => $riskGrading ?? null,
            'terkait'           => $terkait ?? null,
            'fishboneImageData' => $base64Data,
        ]);

        return $pdf->stream($insiden->insiden . '.pdf');
    }
}
