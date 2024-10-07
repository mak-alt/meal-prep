<?php

namespace App\Http\Requests\Frontend\Loyalty\Gifts;

use Illuminate\Foundation\Http\FormRequest;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class SendGiftCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $cardExpirationChunks = explode('/', $this->expiration);

        $this->merge([
            'card_number'      => str_replace(' ', '', $this->card_number),
            'expiration_month' => $cardExpirationChunks[0] ?? null,
            'expiration_year'  => $cardExpirationChunks[1] ?? null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'card_number'      => ['required', new CardNumber()],
            'expiration_month' => ['required', new CardExpirationMonth($this->request->get('expiration_year'))],
            'expiration_year'  => ['required', new CardExpirationYear($this->request->get('expiration_month'))],
            'csc'              => ['required', new CardCvc($this->request->get('card_number'))],
            'card_name'        => ['required', 'max:255'],
        ];
    }
}
