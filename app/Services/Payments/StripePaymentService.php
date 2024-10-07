<?php

namespace App\Services\Payments;

use App\Models\Setting;
use App\Services\Payments\Contracts\PaymentInterface;
use Cartalyst\Stripe\Stripe;

class StripePaymentService implements PaymentInterface
{
    public const PAYMENT_SUCCESS_STATUS = 'succeeded';

    /**
     * @var \Cartalyst\Stripe\Stripe
     */
    protected Stripe $stripe;

    /**
     * StripePaymentService constructor.
     */
    public function __construct()
    {
        $this->stripe = Stripe::make(Setting::getPaymentServicesCredentials()['stripe_secret']);
    }

    /**
     * @param array $customerData
     * @param float $amount
     * @param string $currency
     * @return array
     */
    public function makeSingleCharge(array $customerData, float $amount, string $currency = 'USD'): array
    {
        if (!empty($customerData['user'])) {
            $customerId = optional($customerData['user'])->stripe_customer_id
                ? $customerData['user']->stripe_customer_id
                : $this->createCustomer($customerData['user']->email)['id'];
        } else {
            $customerId = $this->createCustomer()['id'];
        }

        if (!empty($customerData['card'])) {
            $card = $this->createCard($customerId, [
                'card_number' => $customerData['card']['number'],
                'exp_month'   => $customerData['card']['exp_month'],
                'exp_year'    => $customerData['card']['exp_year'],
                'cvc'         => $customerData['card']['cvc'],
            ]);
        }

        $chargeData = [
            'currency'    => $currency,
            'amount'      => $amount,
            'customer'    => $customerId,
            'description' => $customerData['description'] ?? null,
        ];

        if (!empty($customerData['card_id'])) {
            $chargeData['source'] = $customerData['card_id'];
        }

        $chargeResponse = $this->stripe->charges()->create($chargeData);

        if (isset($card)) {
            $this->deleteCard($customerId, $card['id']);
        }

        return $chargeResponse;
    }

    /**
     * @param string|null $email
     * @return array
     */
    public function createCustomer(?string $email = null): array
    {
        return $this->stripe->customers()->create(['email' => $email]);
    }

    /**
     * @param string $customerId
     * @param array $cardDetails
     * @return array
     */
    public function createCard(string $customerId, array $cardDetails): array
    {
        $token = $this->stripe->tokens()->create([
            'card' => [
                'number'    => $cardDetails['card_number'],
                'exp_month' => $cardDetails['exp_month'],
                'exp_year'  => $cardDetails['exp_year'],
                'cvc'       => $cardDetails['cvc'],
            ],
        ]);

        return $this->stripe->cards()->create($customerId, $token['id']);
    }

    /**
     * @param string $customerId
     * @param string $cardId
     * @return array
     */
    public function deleteCard(string $customerId, string $cardId): array
    {
        return $this->stripe->cards()->delete($customerId, $cardId);
    }
}
