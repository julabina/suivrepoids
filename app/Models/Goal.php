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
 * Class Goal
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $weight_goal
 * @property int|null $imc_goal
 * @property int|null $img_goal
 * @property bool $current
 * @property bool $success
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Goal extends Model
{
    use HasFactory;

    protected $table = 'goals';

    protected $casts = [
        'user_id' => 'int',
        'weight_goal' => 'int',
        'imc_goal' => 'int',
        'img_goal' => 'int',
        'current' => 'bool',
        'success' => 'bool',
    ];

    protected $fillable = [
        'user_id',
        'weight_goal',
        'imc_goal',
        'img_goal',
        'current',
        'success',
    ];

    /**
     * @return BelongsTo<User, Goal>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
