<?php

namespace App\Action;

use App\Models\Insiden;

class UpdateInsidenAfterInvestigation
{
    public static function handle(Insiden $insiden, $data)
    {
        $model = $insiden->find($data['insiden_id']);
        if ($model) {
            $model->created_sign = $data['created_sign'];
            $model->received_sign = $data['received_sign'];
            $model->created_by = $data['created_by'] ?? auth()->id();
            $model->received_by = $data['kepala_id'];
            $model->received_at = $data['received_at'] ?? now();
            $model->update();
        }
    }
}
