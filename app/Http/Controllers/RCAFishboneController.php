<?php

namespace App\Http\Controllers;

use App\Models\RootCauseAnalysis;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;


class RCAFishboneController extends Controller
{
    public function render(Request $request)
    {
        if (!$request->has('key') || !$request->has('id')) {
            dd("Key not found, please provide key");
        }

        $key = $request->key;
        $id = $request->id;

        $rca = RootCauseAnalysis::findOrFail($id);
        $fishboneData = $this->getFishboneData($rca);
        $mappedFishboneData = $this->mapFishboneData($fishboneData[$key]['data']);

        return view('rca.fishbone', [
            'key'  => $key,
            'data' => $mappedFishboneData
        ]);
    }
    
    public function fishbone(RootCauseAnalysis $rca)
    {
        $fishboneData = $this->getFishboneData($rca);
        $mappedFishboneData = $fishboneData->map(function ($data) {
            return $this->mapFishboneData($data['data']);
        });

        dd($mappedFishboneData, csrf_token());
    }

    public function getFishboneData(RootCauseAnalysis $rca)
    {
        $identifikasiMasalah = collect($rca->identifikasi_masalah);
        $fishboneData = $identifikasiMasalah->where('type', 'fishbone');

        return $fishboneData;
    }

    public function mapFishboneData($data)
    {
        return [
            "text" => $data['masalah'] ?? "Undefined",
            "size" => 14,
            "weight" => "Bold",
            "causes" => array_map(function ($cause) {
                return [
                    "text" => $cause["causes"],
                    "size" => 12,
                    "causes" => $this->mapFishboneCauses(array_values($cause["sub_causes"]))
                ];
            }, array_values($data['repeater-causes']))
        ];
    }

    public function mapFishboneCauses($causes)
    {
        return array_map(function ($cause) {
            $mapped = ["text" => $cause["sub_causes"]];
            if (isset($cause["children"])) {
                $mapped["causes"] = $this->mapFishboneCauses($cause["children"]);
            }
            return $mapped;
        }, $causes);
    }
}
