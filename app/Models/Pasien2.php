<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien2 extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $perPage = 20;
    protected $connection = 'mysql2';

}
