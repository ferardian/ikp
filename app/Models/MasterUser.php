<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterUser extends Model
{
    protected $table = 'user';
    protected $connection = 'mysql2';
    protected $fillable = [];
    protected $primaryKey = 'id_user';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;


    public function scopeGetPasswordDecryptedById($query, $username)
    {
        return $query->whereRaw("AES_DECRYPT(id_user, ?) = ?", [config('database.aes_keys.id_user'), $username])
            ->selectRaw("AES_DECRYPT(password, ?) as passwd", [config('database.aes_keys.password')]);
    }
    

    public function getRouteKeyName()
    {
        return 'username';
    }

    function pegawai()
    {
        return $this->hasOne(MasterUser::class, 'id_user', 'nik');
    }
}
