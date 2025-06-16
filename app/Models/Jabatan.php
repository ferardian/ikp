<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Jabatan
 *
 * @package App
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jabatan withoutTrashed()
 * @mixin \Eloquent
 */
class Jabatan extends Model
{
    use SoftDeletes;

    protected $perPage = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jabatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['kode', 'nama', 'deskripsi'];
}
