<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class WeightInfo
 *
 * @property int $id
 * @property int $user_id
 * @property int $weight
 * @property float $bmi
 * @property float $bfp
 * @property Carbon $record_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WeightInfo extends Model
{
    use HasFactory;

    protected $table = 'weight_infos';

    protected $casts = [
        'user_id' => 'int',
        'weight' => 'int',
        'bmi' => 'float',
        'bfp' => 'float',
        'record_date' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'weight',
        'bmi',
        'bfp',
        'record_date',
    ];

    /**
     * @return BelongsTo<User, WeightInfo>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
