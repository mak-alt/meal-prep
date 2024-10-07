<?php

namespace App\Http\Controllers\Frontend\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Loyalty\Gifts\RedeemGiftCardRequest;
use App\Http\Requests\Frontend\Loyalty\Gifts\RememberGiftContactsInfoRequest;
use App\Http\Requests\Frontend\Loyalty\Gifts\RememberGiftOptionsRequest;
use App\Http\Requests\Frontend\Loyalty\Gifts\SendGiftCertificateRequest;
use App\Models\Gift;
use App\Models\PaymentHistory;
use App\Models\PaymentLogs;
use App\Models\Setting;
use App\Services\Payments\PayPalPaymentService;
use App\Services\Payments\StripePaymentService;
use Carbon\Carbon;
use CardDetect\Detector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\controller\CreateTransactionController;

class GiftController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        session()->forget('gift');
        return \view('frontend.gifts.index');
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Gifts\RememberGiftOptionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rememberGiftOptions(RememberGiftOptionsRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            foreach ($request->except('_token') as $key => $value) {
                session()->put("gift.$key", $value);
            }

            return response()->json($this->formatResponse('success'));
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Gifts\RememberGiftContactsInfoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rememberGiftContactsInfo(RememberGiftContactsInfoRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            foreach ($request->except('_token') as $key => $value) {
                session()->put("gift.$key", $value);
            }

            $user = auth()->user() ?? null;
            $data = session()->get('gift');
            foreach (['amount', 'delivery_channel', 'sent_to', 'sender_name', 'message'] as $requiredSessionKey) {
                if (empty($data[$requiredSessionKey])) {
                    return response()->json($this->formatResponse('error', 'Not all data has been filled in.'), 400);
                }
            }
            $chargeResponse = (new PayPalPaymentService())->prepareSingleCharge([
                'description' => 'Payment for order',
                'return_url'  => route('frontend.gifts.paypal.send-after-payment'),
                'cancel_url'  => route('frontend.gifts.index'),
            ], $data['amount']);
//            dd($chargeResponse['redirect']->getTargetUrl());

            return response()->json($this->formatResponse('success', null, [
                'redirect' => $chargeResponse['redirect']->getTargetUrl(),
            ]));
//            return response()->json($this->formatResponse('success'));
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Gifts\SendGiftCertificateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
/*    public function send(SendGiftCertificateRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $user = auth()->user() ?? null;
                $data = session()->get('gift');

                foreach (['amount', 'delivery_channel', 'sent_to', 'sender_name', 'message'] as $requiredSessionKey) {
                    if (empty($data[$requiredSessionKey])) {
                        return response()->json($this->formatResponse('error', 'Not all data has been filled in.'), 400);
                    }
                }

                $detector = new Detector();
                $paymentsCredentials = Setting::getPaymentServicesCredentials();
                $type = strtolower($detector->detect($request->card_number));
                if ($type === 'amex') $type = 'american express';
                if ($type === 'dinersclub') $type = 'diners club';

                $merchantAuthentication = new MerchantAuthenticationType();
                $merchantAuthentication->setName($paymentsCredentials['merchant_login_id_key']);
                $merchantAuthentication->setTransactionKey($paymentsCredentials['merchant_transaction_key']);

                $refId = 'ref' . time();
                $cardNumber = preg_replace('/\s+/', '', $request->card_number);

                $creditCard = new CreditCardType();
                $creditCard->setCardNumber($cardNumber);
                $creditCard->setExpirationDate(20 . $request->expiration_year . "-" . $request->expiration_month);
                $creditCard->setCardCode($request->csc);

                $paymentOne = new PaymentType();
                $paymentOne->setCreditCard($creditCard);

                $transactionRequestType = new TransactionRequestType();
                $transactionRequestType->setTransactionType("authCaptureTransaction");
                $transactionRequestType->setAmount($data['amount']);
                $transactionRequestType->setPayment($paymentOne);

                $requests = new CreateTransactionRequest();
                $requests->setMerchantAuthentication($merchantAuthentication);
                $requests->setRefId($refId);
                $requests->setTransactionRequest($transactionRequestType);

                $controller = new CreateTransactionController($requests);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

                if ($response != null) {
                    if ($response->getMessages()->getResultCode() == "Ok") {
                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                            $msg_type = "success";

                            PaymentLogs::create([
                                'amount' => $data['amount'],
                                'response_code' => $tresponse->getResponseCode(),
                                'transaction_id' => $tresponse->getTransId(),
                                'auth_id' => $tresponse->getAuthCode(),
                                'message_code' => $tresponse->getMessages()[0]->getCode(),
                                'name_on_card' => $request->card_name,
                                'quantity'=>1
                            ]);
                        } else {
                            $message_text = 'There were some issue with the payment. Please try again later.';
                            $msg_type = "error";

                            if ($tresponse->getErrors() != null) {
                                $message_text = $tresponse->getErrors()[0]->getErrorText();
                                $msg_type = "error";
                            }
                        }
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = "error";

                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getErrors() != null) {
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = "error";
                        } else {
                            $message_text = $response->getMessages()->getMessage()[0]->getText();
                            $msg_type = "error";
                        }
                    }
                } else {
                    $message_text = "No response returned";
                    $msg_type = "error";
                }

                if ($msg_type === 'error'){
                    return response()->json($this->formatResponse($msg_type, $message_text), 402);
                }


                if (isset($user)){
                    $paymentHistory = PaymentHistory::storePayment([
                        'user_id'         => $user->id,
                        'payment_service' => PaymentHistory::PAYMENT_SERVICE_NAMES['authorize'],
                        'amount'          => $data['amount'],
                        'transaction_id'  => $tresponse->getTransId(),
                        'status'          => $msg_type,
                        'card_last_4'     => $request->card_number,
                        'description'     => "Gift certificate purchased for {$data['sent_to']}",
                        'receipt_url'     => null,
                        'created_at'      => now(),
                    ]);
                }

                Gift::storeGift($data);

                session()->forget('gift');

                return response()->json($this->formatResponse('success', 'Gift card has been successfully purchased and created.'));
            } catch (\Throwable $exception) {
                dd($exception->getMessage());
                return response()->json(
                    $this->formatResponse(
                        'error',
                        'Sending gift card failed.'
                    ), $exception->getCode() === 402 ? 402 : 400
                );
            }
        }
    }*/
    public function send(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $user = auth()->user() ?? null;
                $data = session()->get('gift');

                foreach (['amount', 'delivery_channel', 'sent_to', 'sender_name', 'message'] as $requiredSessionKey) {
                    if (empty($data[$requiredSessionKey])) {
                        return response()->json($this->formatResponse('error', 'Not all data has been filled in.'), 400);
                    }
                }
                $chargeResponse = (new PayPalPaymentService())->prepareSingleCharge([
                    'description' => 'Payment for order',
                    'return_url'  => route('frontend.gifts.paypal.send-after-payment'),
                    'cancel_url'  => route('frontend.gifts.index'),
                ], $data['amount']);

                return response()->json($this->formatResponse('success', null, [
                    'redirect' => $chargeResponse['redirect']->getTargetUrl(),
                ]));

/*
                $detector = new Detector();
                $paymentsCredentials = Setting::getPaymentServicesCredentials();
                $type = strtolower($detector->detect($request->card_number));
                if ($type === 'amex') $type = 'american express';
                if ($type === 'dinersclub') $type = 'diners club';

                $merchantAuthentication = new MerchantAuthenticationType();
                $merchantAuthentication->setName($paymentsCredentials['merchant_login_id_key']);
                $merchantAuthentication->setTransactionKey($paymentsCredentials['merchant_transaction_key']);

                $refId = 'ref' . time();
                $cardNumber = preg_replace('/\s+/', '', $request->card_number);

                $creditCard = new CreditCardType();
                $creditCard->setCardNumber($cardNumber);
                $creditCard->setExpirationDate(20 . $request->expiration_year . "-" . $request->expiration_month);
                $creditCard->setCardCode($request->csc);

                $paymentOne = new PaymentType();
                $paymentOne->setCreditCard($creditCard);

                $transactionRequestType = new TransactionRequestType();
                $transactionRequestType->setTransactionType("authCaptureTransaction");
                $transactionRequestType->setAmount($data['amount']);
                $transactionRequestType->setPayment($paymentOne);

                $requests = new CreateTransactionRequest();
                $requests->setMerchantAuthentication($merchantAuthentication);
                $requests->setRefId($refId);
                $requests->setTransactionRequest($transactionRequestType);

                $controller = new CreateTransactionController($requests);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

                if ($response != null) {
                    if ($response->getMessages()->getResultCode() == "Ok") {
                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                            $msg_type = "success";

                            PaymentLogs::create([
                                'amount' => $data['amount'],
                                'response_code' => $tresponse->getResponseCode(),
                                'transaction_id' => $tresponse->getTransId(),
                                'auth_id' => $tresponse->getAuthCode(),
                                'message_code' => $tresponse->getMessages()[0]->getCode(),
                                'name_on_card' => $request->card_name,
                                'quantity'=>1
                            ]);
                        } else {
                            $message_text = 'There were some issue with the payment. Please try again later.';
                            $msg_type = "error";

                            if ($tresponse->getErrors() != null) {
                                $message_text = $tresponse->getErrors()[0]->getErrorText();
                                $msg_type = "error";
                            }
                        }
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = "error";

                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getErrors() != null) {
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = "error";
                        } else {
                            $message_text = $response->getMessages()->getMessage()[0]->getText();
                            $msg_type = "error";
                        }
                    }
                } else {
                    $message_text = "No response returned";
                    $msg_type = "error";
                }

                if ($msg_type === 'error'){
                    return response()->json($this->formatResponse($msg_type, $message_text), 402);
                }


                if (isset($user)){
                    $paymentHistory = PaymentHistory::storePayment([
                        'user_id'         => $user->id,
                        'payment_service' => PaymentHistory::PAYMENT_SERVICE_NAMES['authorize'],
                        'amount'          => $data['amount'],
                        'transaction_id'  => $tresponse->getTransId(),
                        'status'          => $msg_type,
                        'card_last_4'     => $request->card_number,
                        'description'     => "Gift certificate purchased for {$data['sent_to']}",
                        'receipt_url'     => null,
                        'created_at'      => now(),
                    ]);
                }*/
            } catch (\Throwable $exception) {
                return response()->json(
                    $this->formatResponse(
                        'error',
                        'Sending gift card failed.'
                    ), $exception->getCode() === 402 ? 402 : 400
                );
            }
        }
    }


    public function sendAfterPayPalPayment(Request $request)
    {
            try {
                $data = session()->get('gift');
                Gift::storeGift($data);

                session()->forget('gift');
                return redirect()->route('frontend.gifts.index')->with(['success' => 'Gift card has been successfully purchased and created.']);

//                return response()->json($this->formatResponse('success', 'Gift card has been successfully purchased and created.'));
            } catch (\Throwable $exception) {
                dd($exception->getMessage());
                return response()->json(
                    $this->formatResponse(
                        'error',
                        'Sending gift card failed.'
                    ), $exception->getCode() === 402 ? 402 : 400
                );
            }
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Gifts\RedeemGiftCardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function redeem(RedeemGiftCardRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $gift = Gift::where('code', $request->code)->firstOrFail();

                $gift->redeem($request->code);

                return response()->json($this->formatResponse('success', 'Gift card has been successfully redeemed.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Gift card redeem failed.'), 400);
            }
        }
    }
}
