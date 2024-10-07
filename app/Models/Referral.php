<?php

namespace App\Models;

use App\Notifications\Loyalty\Referrals\ReferralInvitationSent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class Referral extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending' => 'pending',
        'active'  => 'active',
    ];

    public const DELIVERY_CHANNELS = [
        'email'    => 'email',
        'facebook' => 'facebook',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'inviter_id',
        'user_id',
        'user_email',
        'status',
        'user_first_order_at',
        'inviter_money_gained',
        'inviter_money_spent',
    ];

    /**
     * @return int
     */
    public function getUnusedInviterMoney(): int
    {
        return $this->attributes['inviter_money_gained'] - $this->attributes['inviter_money_spent'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUSES['pending'];
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUSES['active'];
    }

    /**
     * @return string
     */
    public static function getDefaultInvitationSubject(): string
    {
        $appName = config('app.name');

        return "Invitation to join referral program on $appName.";
    }

    /**
     * @return string
     */
    public static function getDefaultInvitationMessage(): string
    {
        $appName = config('app.name');

        return "Join $appName referral program to gain benefits together.";
    }

    /**
     * @param array $data
     * @return $this|null
     */
    public static function storeReferral(array $data): ?self
    {
        /*if (isset($data['inviter_id']) && isset($data['user_email'])){*/
        $ref = Referral::where([
            ['inviter_id', $data['inviter_id']],
            ['user_email', $data['user_email']],
        ])->first();
        if ($ref){
            $ref = Referral::where([
                ['inviter_id', $data['inviter_id']],
                ['user_email', $data['user_email']],
                ])->first();
            $ref->fill($data);
            $ref->save();
            return $ref;
        }
        else return self::create($data);
    }

    /**
     * @param array $data
     * @param string $deliveryChannel
     * @return bool
     */
    public static function storeReferralAndSendInvitationNotification(array $data, string $deliveryChannel): bool
    {
        if (!in_array($deliveryChannel, self::DELIVERY_CHANNELS)) {
            throw new \InvalidArgumentException('Wrong delivery channel.');
        }

        $referral = self::storeReferral([
            'inviter_id' => auth()->id(),
            'user_email' => $data['email'] ?? null,
        ]);

        if ($deliveryChannel === self::DELIVERY_CHANNELS['email']) {
            Notification::route('mail', $data['email'])->notify(
                new ReferralInvitationSent($referral, $data['subject'], $data['message'])
            );
        }

        return true;
    }

    /**
     * @param \App\Models\User $inviter
     * @param \App\Models\User|null $invitee
     * @return bool
     */
    public static function join(User $inviter, ?User $invitee = null): bool
    {
        if (!$invitee) {
            $invitee = auth()->user();
        }

        self::storeReferral([
            'inviter_id'           => $inviter->id,
            'user_id'              => $invitee->id,
            'user_email'           => $invitee->email,
            'status'               => self::STATUSES['pending'],
            'inviter_money_gained' => Setting::key('amountInviteeGets')->first()->data,
        ]);

        return true;
    }
}
