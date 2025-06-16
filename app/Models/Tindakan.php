<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tindakan
 *
 * @package App
 * @property int $id
 * @property int $insiden_id
 * @property string $content
 * @property string $oleh
 * @property string|null $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Insiden $insiden
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereOleh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tindakan extends Model
{

    protected $perPage = 20;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tindakan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['insiden_id', 'content', 'oleh', 'detail'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insiden()
    {
        return $this->belongsTo(Insiden::class, 'insiden_id');
    }
}
