<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Grading
 *
 * @package App
 * @property int $id
 * @property int $insiden_id
 * @property string $grading_risiko
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Insiden $insiden
 * @property-read \App\Models\User $oleh
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereGradingRisiko($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withoutTrashed()
 * @mixin \Eloquent
 */
class Grading extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grading';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['grading_risiko', 'created_by', 'insiden_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oleh()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insiden()
    {
        return $this->belongsTo(Insiden::class);
    }

    public function tindakan(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Tindakan::class, 'insiden_id');
    }
}
