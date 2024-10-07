<?php

namespace App\Models;

use App\Services\Payments\StripePaymentService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentProfile extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'card_number',
        'stripe_card_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storePaymentMethod(array $data): ?self
    {
        $user                 = auth()->user();
        $stripePaymentService = new StripePaymentService();

        if (optional($user)->stripe_customer_id) {
            $customerId = $user->stripe_customer_id;
        } else {
            $customerId = $stripePaymentService->createCustomer(optional($user)->email)['id'];

            if ($user) {
                $user->update(['stripe_customer_id' => $customerId]);
            }
        }

        $card = $stripePaymentService->createCard($customerId, [
            'card_number' => $data['card_number'],
            'exp_month'   => $data['expiration_month'],
            'exp_year'    => $data['expiration_year'],
            'cvc'         => $data['csc'],
        ]);

        return $user->paymentProfiles()->create([
            'card_number'    => $data['card_number'],
            'stripe_card_id' => $card['id'],
        ]);
    }

    /**
     * @return bool|null
     */
    public function deletePaymentMethod(): ?bool
    {
        (new StripePaymentService())->deleteCard(
            $this->user->stripe_customer_id,
            $this->stripe_card_id
        );

        return $this->delete();
    }
}
