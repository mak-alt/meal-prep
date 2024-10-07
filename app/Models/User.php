<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use phpDocumentor\Reflection\Types\Null_;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLES = [
        'user'  => 'user',
        'admin' => 'admin',
    ];

    public const STATUSES = [
        'active'   => 'active',
        'inactive' => 'inactive',
        'banned'   => 'banned',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'role',
        'password',
        'referral_code',
        'stripe_customer_id',
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getFullNameAttribute()
    {
        if ($this->first_name && $this->last_name){
            return "$this->first_name $this->last_name";
        }
        else return null;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function getFirstNameAttribute(): string
    {
        return strtok($this->name, ' ');
    }

    public function getLastNameAttribute(): string
    {
        $nameChunks = explode(' ', $this->name);

        return $nameChunks[1] ?? '';
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userReward(): HasOne
    {
        return $this->hasOne(UserReward::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class, 'receiver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'inviter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function referralUser(): HasOne
    {
        return $this->hasOne(Referral::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentProfiles(): HasMany
    {
        return $this->hasMany(PaymentProfile::class);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLES['admin'];
    }

    /**
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->role === self::ROLES['user'];
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->status === self::STATUSES['banned'];
    }

    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUSES['inactive'];
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUSES['active'];
    }

    /**
     * @return bool
     */
    public function hasDefaultDeliveryAddressSetUp(): bool
    {
        if (!$this->profile()->exists()) {
            return false;
        }

        return !empty($this->profile->delivery_street_address);
    }

    /**
     * @return bool
     */
    public function hasDefaultBillingAddressSetUp(): bool
    {
        if (!$this->profile()->exists()) {
            return false;
        }

        return !empty($this->profile->billing_street_address);
    }

    /**
     * @return bool
     */
    public function hasReferralFirstOrderDiscount(): bool
    {
        return $this->referralUser()
            ->where('status', Referral::STATUSES['pending'])
            ->whereNull('user_first_order_at')
            ->exists();
    }

    /**
     * @return int
     */
    public function getPointsDiscount(): int
    {
        $unusedPoints        = $this->userReward->unused_points ?? 0;
        $pointsDiscountCount = $unusedPoints / 5000 >= 1
            ? round($unusedPoints / 5000, 0, PHP_ROUND_HALF_DOWN)
            : 0;

        return $pointsDiscountCount * 10;
    }

    /**
     * @return int
     */
    public function getGiftsDiscount(): int
    {
        return $this->gifts()
            ->whereNotNull('redeemed_at')
            ->whereNull('used_at')
            ->get()
            ->sum('unused_amount');
    }

    /**
     * @return int
     */
    public function getReferralInviterDiscount(): int
    {
        $sum = 0;
        $referrals = $this->referrals()
            ->where('status', Referral::STATUSES['active'])
            ->whereNotNull('user_first_order_at')
            ->whereColumn('inviter_money_gained', '>', 'inviter_money_spent')
            ->get();
        foreach ($referrals as $referral){
            $sum += $referral->getUnusedInviterMoney();
        }
        return $sum;

        /*return $this->referrals()
            ->where('status', Referral::STATUSES['active'])
            ->whereNotNull('user_first_order_at')
            ->whereColumn('inviter_money_gained', '>', 'inviter_money_spent')
            ->get()
            ->sum('unused_inviter_money');*/
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateUser(array $data): bool
    {
        $data['password'] = !empty($data['password']) ? Hash::make($data['password']) : $this->password;

        return $this->update($data);
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeUser(array $data): ?self
    {
        $password         = !empty($data['password']) ? $data['password'] : Str::random();
        $data['password'] = Hash::make($password);

        return self::create($data);
    }

    /**
     * @param string $newEmail
     * @return bool
     */
    public function updateEmail(string $newEmail): bool
    {
        $isUpdated = $this->update(['email' => $newEmail]);

        if ($isUpdated) {
            if (VerificationCode::where('user_id', auth()->id())->latest()->exists()) {
                VerificationCode::where('user_id', auth()->id())->latest()->first()->delete();
            }
        }

        return true;
    }

    /**
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword(string $newPassword): bool
    {
        return $this->update(['password' => Hash::make($newPassword)]);
    }

    public function usedCoupons()
    {
        return $this->hasMany(UsedCoupon::class);
    }
}
