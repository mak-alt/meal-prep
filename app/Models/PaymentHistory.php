<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentHistory extends Model
{
    use HasFactory;

    public const PAYMENT_SERVICE_NAMES = [
        'stripe' => 'stripe',
        'paypal' => 'paypal',
        'payeezy' => 'payeezy',
        'authorize' => 'authorize',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'payment_service',
        'amount',
        'transaction_id',
        'status',
        'card_last_4',
        'description',
        'receipt_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['id' => null, 'name' => 'Deleted']);
    }

    /**
     * @return bool
     */
    public function isStripe(): bool
    {
        return $this->payment_service === self::PAYMENT_SERVICE_NAMES['stripe'];
    }

    /**
     * @return bool
     */
    public function isPayPal(): bool
    {
        return $this->payment_service === self::PAYMENT_SERVICE_NAMES['paypal'];
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storePayment(array $data): ?self
    {
        return self::create($data);
    }
}
