<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    protected $table = 'jabatan';
    protected $connection = 'mysql2';
    protected $fillable = [];
    protected $primaryKey = 'kd_jbtn';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
}
