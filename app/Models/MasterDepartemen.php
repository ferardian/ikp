<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDepartemen extends Model
{

    protected $table = 'departemen';
    protected $connection = 'mysql2';
    protected $fillable = [];
    protected $primaryKey = 'dep_id';
    public $timestamps = false;
    public $incrementing = false;
}
