<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPegawai extends Model
{
    protected $table = 'pegawai';
    protected $connection = 'mysql2';
    protected $fillable = [];
    protected $primaryKey = 'nik';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function jbtn()
    {
        return $this->belongsTo(MasterJabatan::class, 'jabatan_id');
    }
    public function dprtmn()
    {
        return $this->belongsTo(MasterDepartemen::class, 'departemen');
    }

    public function petugas()
    {
        return $this->hasOne(MasterPetugas::class, 'nip', 'nik');
    }

}
