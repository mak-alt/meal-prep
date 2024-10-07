<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'coupon_code',
        'coupon_name',
        'discount_type',
        'discount_value',
        'expiration_date',
        'start_date',
        'description',
    ];

    /**
     *
     * @return void
     */
    public function setExpirationDateAttribute($value)
    {
        if ($value === null){
            $this->attributes['expiration_date'] = null;
        }
        else{
            $this->attributes['expiration_date'] = Carbon::parse($value)->toDateTimeString();
        }
    }

    /**
     *
     * @return void
     */
    public function setStartDateAttribute($value)
    {
        if ($value === null){
            $this->attributes['expiration_date'] = null;
        }
        else{
            $this->attributes['start_date'] = Carbon::parse($value)->toDateTimeString();
        }

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @param float $startPrice
     * @return float
     */
    public function getDiscountCurrencyValue(float $startPrice): float
    {
        if ($this->discount_type === 'currency') {
            return $this->discount_value;
        }

        return $startPrice * $this->discount_value / 100;
    }
}
