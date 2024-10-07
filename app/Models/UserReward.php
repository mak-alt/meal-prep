<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'total_points',
        'used_points',
    ];

    /**
     * @return int
     */
    public function getUnusedPointsAttribute(): int
    {
        return $this->attributes['total_points'] - $this->attributes['used_points'];
    }

    /**
     * @return int
     */
    public function getPointsLeftToGetTheAwardAttribute(): int
    {
        $pointsLeft = 5000 - $this->unused_points;

        if ($pointsLeft < 0) {
            return 5000 + $pointsLeft;
        }

        return $pointsLeft;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param int $userId
     * @param int $pointsGained
     * @return static|null
     */
    public static function accrueReward(int $userId, int $pointsGained): ?self
    {
        $userReward = self::where('user_id', $userId)->firstOrCreate(['user_id' => $userId], ['user_id' => $userId]);

        $userReward->increment('total_points', $pointsGained);

        return $userReward;
    }
}
