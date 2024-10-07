<?php

namespace App\Http\Requests\Backend\Settings;

use App\Services\Payments\PayPalPaymentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'seo_title'                        => ['required', 'string', 'max:100'],
            'seo_description'                  => ['required', 'string', 'max:255'],
            'seo_keywords'                     => ['nullable', 'string', 'max:255'],
            'support_email'                    => ['required', 'string', 'email', 'max:255'],
            'order_email'                      => ['required', 'string', 'email', 'max:255'],
            'support_phone_number'             => ['required', 'string', 'max:14'],
            'support_location'                 => ['nullable', 'string'],
            'facebook_url'                     => ['nullable', 'string', 'url', 'max:255'],
            'twitter_url'                      => ['nullable', 'string', 'url', 'max:255'],
            'instagram_url'                    => ['nullable', 'string', 'url', 'max:255'],
            'payments_credentials'             => ['required', 'array', 'min:5'],
            'payments_credentials.*'           => ['required', 'string'],
            'payments_credentials.paypal_mode' => ['required', 'string', Rule::in(PayPalPaymentService::MODES)],
            'snippetID'                        => ['nullable', 'string'],
            'mailchimp'                        => ['nullable', 'array'],
            'mailchimp.*'                      => ['nullable', 'string'],
            'twillio'                          => ['nullable', 'array'],
            'twillio.*'                        => ['nullable', 'string'],
            'amountInviterGets'                => ['required', 'numeric'],
            'amountInviteeGets'                => ['required', 'numeric'],
            'thumb'                            => ['nullable', 'file'],
            'thumb2'                           => ['nullable', 'file'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'payments_credentials.stripe_key'           => 'Stripe key',
            'payments_credentials.stripe_secret'        => 'Stripe secret',
            'payments_credentials.paypal_mode'          => 'PayPal mode',
            'payments_credentials.paypal_client_id'     => 'PayPal client ID',
            'payments_credentials.paypal_client_secret' => 'PayPal client secret',
        ];
    }
}
