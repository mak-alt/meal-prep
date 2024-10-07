<?php

namespace App\Models;

use App\Mail\SendAdminGiftNotification;
use App\Mail\SendBuyerNotification;
use App\Notifications\Loyalty\Gifts\GiftRedeemed;
use App\Notifications\Loyalty\Gifts\GiftSent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;
use Twilio\Rest\Client;


class Gift extends Model
{
    use HasFactory;

    public const DELIVERY_CHANNELS = [
        'email' => 'email',
        'sms'   => 'sms',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'sender_id',
        'sender_name',
        'receiver_id',
        'sent_via',
        'sent_to',
        'delivery_date',
        'is_sent',
        'amount',
        'used_amount',
        'message',
        'code',
        'used_at',
        'redeemed_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'delivery_date',
        'used_at',
        'redeemed_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = ['is_sent' => 'boolean'];


    /**
     * @return int
     */
    public function getUnusedAmountAttribute(): int
    {
        return $this->attributes['amount'] - $this->attributes['used_amount'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * @param int|null $giftAmount
     * @return string
     */
    public static function getDefaultGiftMessage(?int $giftAmount = null): string
    {
        $appName        = config('app.name');
        $giftAmountText = $giftAmount ? " for $$giftAmount" : '';

        return "Hey, it's ___ ! I've been saving a ton of time while using $appName and thought you could too! I bought you a gift card$giftAmountText. Use the link below to create your free account and your gift card will automatically be applied to your account. Enjoy the gift of more free time!";
    }

    public static function getDefaultGiftSMS(?int $giftAmount = null): string
    {
        $appName        = config('app.name');
        $giftAmountText = $giftAmount ? " for $$giftAmount" : '';

        return "Hey, it's ___ ! I bought you a gift card$giftAmountText on $appName. You can redeem it here: ".route('frontend.gifts.index') . ".";
    }

    /**
     * @param array $data
     * @return static|null
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public static function storeGift(array $data): ?self
    {
        $data['sender_id'] = auth()->id() ?? null;
        $data['code']      = substr(str_shuffle('0123456789'), 0, 16);
        $data['sent_via']  = $data['delivery_channel'];
        if ($data['delivery_channel'] === 'sms'){
            $data['sent_to'] = '+1'. preg_replace('/[^0-9.]+/', '', $data['sent_to']);
            $data['message'] = $data['message'] . " Here is your code: {$data['code']}";
        }
        $gift = self::create($data);

        if ($gift->sent_via === 'sms'){
            $twillioCredentials = optional(Setting::key('twillio')->first())->data ?? [];
            $account_sid = $twillioCredentials['sid'] ?? getenv("TWILIO_SID");
            $auth_token = $twillioCredentials['token'] ?? getenv("TWILIO_TOKEN");
            $twilio_number = $twillioCredentials['from'] ?? getenv("TWILIO_NUMBER");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($gift->sent_to, [
                'from' => $twilio_number,
                'body' => $gift->message]);
            $gift->update(['is_sent' => true]);
        }
        else{
            $gift->sendGiftSentNotification();
        }


        return $gift;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateGift(array $data): bool
    {
        return self::update($data);
    }

    /**
     * @return bool
     */
    public function sendGiftSentNotification(): bool
    {
        // TODO: change to sms channel when SMS API is implemented
        $notificationChannel = $this->sent_via === self::DELIVERY_CHANNELS['email'] ? 'mail' : null;

        Notification::route($notificationChannel, $this->sent_to)->notify(new GiftSent($this));
        \Mail::to($this->sender_name)->send(new SendBuyerNotification($this));
        $email = Setting::key('order_email')->first()->data ?? 'amptestsiteorders@gmail.com';
        \Mail::to($email)->send(new SendAdminGiftNotification($this));

        $this->update(['is_sent' => true]);

        return true;
    }

    /**
     * @param int $code
     * @param int|null $receiverId
     * @return bool
     */
    public function redeem(int $code, ?int $receiverId = null): bool
    {
        if (!$receiverId) {
            $receiverId = auth()->id();
        }

        if (!$receiverId) {
            throw new \InvalidArgumentException('Receiver ID can not be null.');
        }

        $isUpdated = $this->update(['code' => $code, 'receiver_id' => $receiverId, 'redeemed_at' => now()]);

        if ($isUpdated) {
            Notification::route('mail', $this->sent_to)->notify(new GiftRedeemed($this));
        }

        return true;
    }
}
