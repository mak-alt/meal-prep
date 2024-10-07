<?php

namespace App\Services\Payments;

use App\Models\Setting;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PayPalPaymentService
{
    public const MODES = [
        'sandbox' => 'sandbox',
        'live'    => 'live',
    ];

    /**
     * @var ApiContext
     */
    protected ApiContext $apiContext;

    /**
     * PayPalPaymentService constructor.
     */
    public function __construct()
    {
        $config           = $this->getConfig();
        $this->apiContext = new ApiContext(new OAuthTokenCredential($config['client_id'], $config['secret']));
        $this->apiContext->setConfig($config['settings']);
    }

    /**
     * @param array $customerData
     * @param float $amount
     * @param string $currency
     * @return array
     */
    public function prepareSingleCharge(array $customerData, float $amount, string $currency = 'USD'): array
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amountObj = new Amount();
        $amountObj->setCurrency($currency)->setTotal($amount);

        $transaction = new Transaction();
        $transaction->setAmount($amountObj)->setDescription($customerData['description']);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($customerData['return_url']);

        if (!empty($customerData['cancel_url'])) {
            $redirectUrls->setCancelUrl($customerData['cancel_url']);
        }

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (PayPalConnectionException $exception) {
            return ['redirect' => redirect()->back()];
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() === 'approval_url') {
                return ['redirect' => redirect()->away($link->getHref())];
            }
        }

        return ['redirect' => redirect()->back()];
    }

    /**
     * @param string $paymentId
     * @param string $payerId
     * @param string $token
     * @return Payment
     */
    public function executeSingleCharge(string $paymentId, string $payerId, string $token): Payment
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        return $payment->execute($execution, $this->apiContext);
    }

    /**
     * @return array
     */
    private function getConfig(): array
    {
        $credentials = Setting::getPaymentServicesCredentials();

        return [
            'client_id' => $credentials['paypal_client_id'],
            'secret'    => $credentials['paypal_client_secret'],
            'settings'  => [
                'mode'                   => $credentials['paypal_mode'],
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled'         => true,
                'log.FileName'           => storage_path() . '/logs/paypal.log',
                'log.LogLevel'           => 'ERROR',
            ],
        ];
    }
}
