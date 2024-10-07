<?php

namespace App\Services\Payments\Contracts;

interface PaymentInterface
{
    /**
     * @param array $customerData
     * @param float $amount
     * @param string $currency
     * @return array
     */
    public function makeSingleCharge(array $customerData, float $amount, string $currency = 'USD'): array;
}
