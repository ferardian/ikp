<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RootCauseAnalysis extends Model
{
    use SoftDeletes;

    protected $table = 'root_cause_analysis';

    protected $fillable = [
        'ketua_id',
        'members',
        'area_terwakili',
        'pengetahuan_terwakili',
        'notulen_id',
        'kepala_igd_id',
        'tanggal_mulai_investigasi',
        'tanggal_selesai_dilengkapi',
        'insiden_id',
        'data_primer',
        'data_sekunder',
        'data_lainnya',
        'kronologi_waktu_kejadian',
        'identifikasi_masalah',
        'rekomendasi',
        'perubahan_dan_penghalang'
    ];

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function notulen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notulen_id');
    }

    public function kepalaIgd(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepala_igd_id');
    }

    public function insiden(): BelongsTo
    {
        return $this->belongsTo(Insiden::class);
    }

    protected function casts(): array
    {
        return [
            'members' => 'array',
            'tanggal_mulai_investigasi' => 'date',
            'tanggal_selesai_dilengkapi' => 'date',
            'data_primer' => 'array',
            'data_sekunder' => 'array',
            'data_lainnya' => 'array',
            'kronologi_waktu_kejadian' => 'array',
            'identifikasi_masalah' => 'array',
            'rekomendasi' => 'array',
            'perubahan_dan_penghalang' => 'array',
        ];
    }
}
