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

    public function getIdUserDecryptedAttribute()
    {
        return DB::selectOne("SELECT CAST(AES_DECRYPT(?, ?) AS CHAR) AS decrypted", [
            $this->attributes['id_user'],
            config('database.aes_keys.id_user')
        ])?->decrypted;
    }

}
