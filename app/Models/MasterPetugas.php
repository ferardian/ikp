<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MasterPetugas extends Model
{
    protected $table = 'petugas';
    protected $connection = 'mysql2';
    protected $fillable = [];
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected static function booted()
    {
        static::addGlobalScope('nip', function (Builder $builder) {
            $builder->where('nip', '!=', '-');
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class, 'nip');
    }

    public function jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'kd_jbtn', 'kd_jbtn');
    }

}
