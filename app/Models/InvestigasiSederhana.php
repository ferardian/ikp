<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int $kepala_id
 * @property int $insiden_id
 * @property string $penyebab_insiden
 * @property string $penyebab_melatarbelakangi
 * @property string $rekomendasi
 * @property int $penanggung_jawab_rekomendasi
 * @property string $tanggal_rekomendasi
 * @property string $tindakan_rekomendasi
 * @property int $penanggung_jawab_tindakan
 * @property string $tanggal_tindakan
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $lengkap
 * @property string $investigasi_lanjut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Insiden $insiden
 * @property-read \App\Models\User $kepala
 * @property-read \App\Models\User $pj_rekomendasi
 * @property-read \App\Models\User $pj_tindakan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereInvestigasiLanjut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereKepalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenanggungJawabRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenanggungJawabTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenyebabInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana wherePenyebabMelatarbelakangi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTanggalTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereTindakanRekomendasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvestigasiSederhana withoutTrashed()
 * @mixin \Eloquent
 */
class InvestigasiSederhana extends Model
{
    use SoftDeletes;

    protected $table = 'investigasi_sederhana';

    protected $fillable = [
        'kepala_id', 'insiden_id',
        'penyebab_insiden', 'penyebab_melatarbelakangi',
        'rekomendasi', 'penanggung_jawab_rekomendasi', 'tanggal_rekomendasi',
        'tindakan_rekomendasi', 'penanggung_jawab_tindakan', 'tanggal_tindakan',
        'tanggal_mulai', 'tanggal_selesai',
        'lengkap', 'investigasi_lanjut'
    ];

    protected $casts = [
        'tanggal_rekomendasi' => 'datetime',
        'tanggal_tindakan' => 'datetime',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kepala()
    {
        return $this->belongsTo(User::class, 'kepala_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insiden()
    {
        return $this->belongsTo(Insiden::class);
    }

    public function pj_rekomendasi()
    {
        return $this->belongsTo(\App\Models\User::class, 'penanggung_jawab_rekomendasi', 'id');
    }

    public function pj_tindakan()
    {
        return $this->belongsTo(\App\Models\User::class, 'penanggung_jawab_tindakan', 'id');
    }

    
}
