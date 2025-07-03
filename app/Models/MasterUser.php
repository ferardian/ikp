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

    protected $appends = ['username', 'passwd'];

    public function getUsernameAttribute()
    {
        return DB::connection($this->connection)
            ->table($this->table)
            ->selectRaw("AES_DECRYPT(id_user, ?) as username", [config('database.aes_keys.id_user')])
            ->where('id_user', $this->attributes['id_user'])
            ->value('username');
    }

    public function getPasswdAttribute()
    {
        return DB::connection($this->connection)
            ->table($this->table)
            ->selectRaw("AES_DECRYPT(password, ?) as passwd", [config('database.aes_keys.password')])
            ->where('id_user', $this->attributes['id_user'])
            ->value('passwd');
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
